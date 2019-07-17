<?php

namespace MailOptin\MailjetConnect;

use MailOptin\Core\Connections\ConnectionInterface;

class Connect extends AbstractMailjetConnect implements ConnectionInterface
{
    /**
     * @var string key of connection service. its important all connection name ends with "Connect"
     */
    public static $connectionName = 'MailjetConnect';

    public function __construct()
    {
        ConnectSettingsPage::get_instance();

        add_filter('mailoptin_registered_connections', array($this, 'register_connection'));

        parent::__construct();
    }

    public static function features_support($connection_service = '')
    {
        return [
            self::OPTIN_CAMPAIGN_SUPPORT,
            self::EMAIL_CAMPAIGN_SUPPORT,
            self::OPTIN_CUSTOM_FIELD_SUPPORT
        ];
    }


    /**
     * Register Mailjet Connection.
     *
     * @param array $connections
     *
     * @return array
     */
    public function register_connection($connections)
    {
        $connections[self::$connectionName] = __('Mailjet', 'mailoptin');

        return $connections;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function replace_placeholder_tags($content, $type = 'html')
    {
        $search = [
            '{{webversion}}',
            '{{unsubscribe}}'
        ];

        $replace = [
            '[[PERMALINK]]',
            // can also be [[UNSUB_LINK_EN]] or just [[UNSUB_LINK]]
            // see https://app.mailjet.com/support/how-can-i-add-an-unsubscribe-link-to-my-newsletter,103.htm
            '[[UNSUB_LINK_LOCALE]]'
        ];

        $content = str_replace($search, $replace, $content);

        return $this->replace_footer_placeholder_tags($content);
    }

    /**
     * {@inherit_doc}
     *
     * Return array of email list
     *
     * @return mixed
     */
    public function get_email_list()
    {
        try {
            return $this->mailjet_instance()->get_lists();
        } catch (\Exception $e) {
            self::save_optin_error_log($e->getMessage(), 'mailjet');
        }
    }

    /**
     * Fetch user defined custom fields
     */
    public function get_optin_fields($list_id = '')
    {
        try {
            return $this->mailjet_instance()->get_custom_fields();
        } catch (\Exception $e) {
            self::save_optin_error_log($e->getMessage(), 'mailjet');
        }
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param int $email_campaign_id
     * @param int $campaign_log_id
     * @param string $subject
     * @param string $content_html
     * @param string $content_text
     *
     * @throws \Exception
     *
     * @return array
     */
    public function send_newsletter($email_campaign_id, $campaign_log_id, $subject, $content_html, $content_text)
    {
        return (new SendCampaign($email_campaign_id, $campaign_log_id, $subject, $content_html, $content_text))->send();
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $list_id ID of email list to add subscriber to
     * @param mixed|null $extras
     *
     * @return mixed
     */
    public function subscribe($email, $name, $list_id, $extras = null)
    {
        return (new Subscription($email, $name, $list_id, $extras))->subscribe();
    }

    /**
     * Singleton poop.
     *
     * @return Connect|null
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}