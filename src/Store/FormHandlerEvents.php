<?php

namespace TBoileau\FormHandlerBundle\Store;

/**
 * Class FormHandlerEvents
 * @package TBoileau\FormHandlerBundle\Store
 * @author Thomas Boileau <t-boileau@email.com>
 */
class FormHandlerEvents
{
    const PRE_CONFIGURE_FORM = "tboileau_form_handler.events.pre_configure_form";

    const PRE_CREATE_FORM = "tboileau_form_handler.events.pre_create_form";

    const PRE_HANDLE_REQUEST = "tboileau_form_handler.events.pre_handle_request";

    const POST_HANDLE_REQUEST = "tboileau_form_handler.events.post_handle_request";

    const PRE_PROCESS_HANDLER = "tboileau_form_handler.events.pre_process_handler";

    const POST_PROCESS_HANDLER = "tboileau_form_handler.events.post_process_handler";

    const POST_VALID_FORM = "tboileau_form_handler.events.post_valid_form";

    const PRE_CREATE_VIEW = "tboileau_form_handler.events.pre_create_view";
}