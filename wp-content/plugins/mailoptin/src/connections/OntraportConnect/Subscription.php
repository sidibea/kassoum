<?php

namespace MailOptin\OntraportConnect;

class Subscription extends AbstractOntraportConnect
{
    public $email;
    public $name;
    public $list_id;
    public $extras;

    public function __construct($email, $name, $list_id, $extras)
    {
        $this->email   = $email;
        $this->name    = $name;
        $this->list_id = $list_id;
        $this->extras  = $extras;

        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function subscribe()
    {
        try {

            //Prepare subscriber data
            $name_split = self::get_first_last_names($this->name);
            $data       = [
                "firstname" => $name_split[0],
                "lastname"  => $name_split[1],
                "email"     => $this->email
            ];

            $subscriber_tags = array_map(
                'absint',
                $this->get_integration_data('OntraportConnect_subscriber_tags')
            );

            //Add custom fields
            $custom_field_mappings = $this->form_custom_field_mappings();
            if ( ! empty($custom_field_mappings)) {

                foreach ($custom_field_mappings as $OntraportKey => $customFieldKey) {

                    // we are checking if $customFieldKey is not empty because if a merge field doesn't have a custom field
                    // selected for it, the default "Select..." value is empty ("")
                    if ( ! empty($customFieldKey) && ! empty($this->extras[$customFieldKey])) {
                        $data[$OntraportKey] = $this->extras[$customFieldKey];
                    }
                }
            }

            $data = array_filter($data, [$this, 'data_filter']);

            $response = $this->ontraportInstance()->add_subscriber($data);

            if (is_array($response) && isset($response['attrs']['id'])) {

                if (isset($this->extras['mo-acceptance']) && $this->extras['mo-acceptance'] == 'yes') {
                    $gdpr_tag = apply_filters('mo_connections_ontraport_acceptance_tag', 'GDPR');
                    try {
                        $result = $this->ontraportInstance()->make_request('Tags/saveorupdate',
                            ['tag_name' => $gdpr_tag],
                            'post'
                        );

                        if (isset($result['data']['tag_id'])) {
                            $subscriber_tags[] = $result['data']['tag_id'];
                        }

                    } catch (\Exception $e) {
                    }
                }

                if ( ! empty($subscriber_tags)) {
                    $this->ontraportInstance()->add_tags(
                        $response['attrs']['id'],
                        $subscriber_tags
                    );
                }

                return parent::ajax_success();
            }

            return parent::ajax_failure(__('There was an error saving your contact. Please try again.', 'mailoptin'));

        } catch (\Exception $e) {

            self::save_optin_error_log($e->getCode() . ': ' . $e->getMessage(), 'ontraport', $this->extras['optin_campaign_id']);

            return parent::ajax_failure(__('There was an error saving your contact. Please try again.', 'mailoptin'));
        }
    }
}