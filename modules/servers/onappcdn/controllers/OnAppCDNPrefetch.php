<?php
/**
 * 
 */
class OnAppCDNPrefetch extends OnAppCDN {

    public function __construct () {
        parent::__construct();
        parent::init_wrapper();
    }

    /**
     *
     * @param string $errors Errors
     * @param string $messages Errors
     */
    public function show( $errors = null, $messages = null ) {
        
        $this->show_template(
            'onappcdn/cdn_resources/prefetch',
            array(
                'id'                =>  parent::get_value('id'),
                'resource_id'       =>  parent::get_value('resource_id'),
                'errors'            =>  implode( PHP_EOL, $errors ),
                'messages'          =>  implode( PHP_EOL, $messages ),
            )
        );
    }

    /**
     *
     *
     */
    protected function prefetch () {
        parent::loadcdn_language();
        global $_LANG;

        $onapp    = $this->getOnAppInstance();
        $id       = parent::get_value('resource_id');
        $prefetch = parent::get_value('prefetch');
        
        if ( $onapp->getErrorsAsArray() )
            $errors[] = implode( PHP_EOL , $onapp->getErrorsAsArray() );

        $cdn_resource  = $onapp->factory('CDNResource', true );

        $prefetch_paths = trim( $prefetch['prefetch_paths'] );

        $cdn_resource->prefetch( $id, $prefetch_paths );

        if ( $cdn_resource->getErrorsAsArray() )
            $errors[] = implode( PHP_EOL , $cdn_resource->getErrorsAsArray() );

        if ( ! $errors )
            $messages[] = $_LANG['onappcdnprefetchsuccessfully'];

        $this->show( $errors, $messages );
    }
}

