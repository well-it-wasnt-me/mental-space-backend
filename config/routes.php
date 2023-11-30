<?php

use App\Middleware\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', \App\Action\Home\HomeAction::class)->setName('home');

    $app->get('/whatsapp', \App\Action\Home\HomeAction::class)->setName('whatsapp');
    // Swagger API documentation
    $app->get('/docs/v1', \App\Action\OpenApi\Version1DocAction::class)->setName('docs');

    $app->post('/doc_login', \App\Action\Auth\DocLoginSubmitAction::class)->setName('login');

    $app->post('/user_login', \App\Action\Auth\UserLoginSubmitAction::class)->setName('user-login');

    $app->post('/register_doc', \App\Action\Users\UserCreateDocAction::class);

    $app->post('/register_paz', \App\Action\Users\UserCreatePazAction::class);

    $app->get('/logout', \App\Action\Auth\LogoutAction::class);


    $app->group('/public', function (RouteCollectorProxy $group) {
        $group->get("/doc_login", \App\Action\Pages\DocLoginPageAction::class)->setName('public_doc_login');
        $group->get("/paziente_login", \App\Action\Pages\PazLoginPageAction::class)->setName('public_paz_login');
        $group->get("/admin_login", \App\Action\Pages\AdminLoginPageAction::class)->setName('public_admin_login');
        $group->get("/register_doc", \App\Action\Pages\RegisterDocPageAction::class)->setName('register_doc');
        $group->get("/privacy", \App\Action\Pages\PrivacyPageAction::class)->setName('privacy-policy');
        $group->get("/terms", \App\Action\Pages\TermsPageAction::class)->setName('terms');
        $group->post("/stripe/webhook", \App\Action\Stripe\webhook::class)->setName('wh');
        $group->get("/consulto/{codice}", \App\Action\Pages\ConsultoPageAction::class)->setName('consulto');
        $group->post("/pincode/check", \App\Action\Consulti\PinCodeActionCheck::class)->setName('consulto-pin-check');
        $group->post("/hack/attempt", \App\Action\Security\HackAttemptAction::class)->setName('log-hack-attempt');
        $group->get('/create-checkout-session', \App\Action\Pages\CreateCheckoutSession::class)->setName('payment-page');
    });

    $app->group('/pages', function (RouteCollectorProxy $group) {
        $group->get("/home_doctor", \App\Action\Pages\HomeDocPageAction::class)->setName('pages-home-doc');
        $group->get("/doctor_detail[/{esito}]", \App\Action\Pages\DetailDocPageAction::class)->setName('doctor-detail');
        $group->get("/messages", \App\Action\Pages\MessagesDocPageAction::class)->setName('doctor-detail');
        $group->get("/patients/detail/{paz_id}", \App\Action\Pages\PatientDetailAction::class)->setName('pages-view-patient');
        $group->get("/calendar", \App\Action\Pages\CalendarAction::class)->setName('calendar');
        $group->get("/reports", \App\Action\Pages\ReportsAction::class)->setName('reports');
        $group->get("/faq", \App\Action\Pages\FaqPageAction::class)->setName('reports');

        $group->get("/patients/add", \App\Action\Pages\AddPatientsAction::class)->setName('add-patient');
        $group->get("/patients/list", \App\Action\Pages\ListSmartboxAction::class)->setName('list-patient');

    })->add(UserAuthMiddleware::class);

    // API endpoints. This group is protected with JWT.
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/patients/add', \App\Action\Patients\AddPatientAction::class);
        $group->get('/patients/list', \App\Action\Patients\ListPatAction::class);
        $group->get('/patients/list/last_10_mood/{paz_id}', \App\Action\Patients\List10MoodPatientAction::class);
        $group->get('/patients/list/diary/{user_id}', \App\Action\Patients\ListDiaryPatientAction::class);
        $group->get('/patients/pharm/list/{paz_id}', \App\Action\Patients\ListPharmPatientAction::class);
        $group->post('/patients/update', \App\Action\Patients\UpdatePatientAction::class);
        $group->get('/patients/file/list/{user_id}',\App\Action\Files\DocFileListAction::class);
        $group->post('/patient/file/download', \App\Action\Files\DocFileDownloadAction::class);
        $group->post('/patient/file/upload', \App\Action\Files\DocFileUploadAction::class);
        $group->post('/patient/file/delete', \App\Action\Files\DocFileDeleteAction::class);
        $group->get('/patient/mood/all/{user_id}', \App\Action\Patients\ListAllMoodPatientAction::class);
        $group->get('/patient/depressione/all/{user_id}', \App\Action\Patients\ListAllDeprePatientAction::class);
        $group->get('/account/delete', \App\Action\Users\UserDocDeleteAction::class);
        $group->get('/login/history', \App\Action\Users\UserHistoryAction::class);
        $group->post('/password/update', \App\Action\Users\UserPasswordChange::class);
        $group->post('/drugs/list/search', \App\Action\Pharm\WebSearchByNameAction::class);
        $group->get('/search/patient/{full_name}', \App\Action\Patients\SearchPatAction::class);
        $group->get('/invoices/list', \App\Action\Invoices\ListInvoiceAction::class);
        $group->get('/patient/pills/add/{paz_id}/{pill_id}',\App\Action\Patients\AddPillPatientAction::class);
        $group->get('/patient/pills/delete/{paz_id}/{ass_id}',\App\Action\Patients\DelPillPatientAction::class);
        $group->get('/patient/delete/{paz_id}',\App\Action\Patients\DelPatientAction::class);
        $group->get('/patients/list/annotation/{paz_id}', \App\Action\Patients\ListAnnotationPatientAction::class);
        $group->post('/patients/add/annotation', \App\Action\Patients\AddAnnotationPatientAction::class);
        $group->get('/patients/delete/annotation/{ann_id}', \App\Action\Patients\DeleteAnnotationPatientAction::class);
        $group->get('/patients/relazione/{paz_id}', \App\Action\Patients\LoadRelazionePatientAction::class);
        $group->post('/patients/relazione/save', \App\Action\Patients\SalvaRelazionePatientAction::class);
        $group->get('/patient/messsages/contacts', \App\Action\Messages\ListContactsAction::class);
        $group->get('/calendar/list', \App\Action\Calendar\ListEventAction::class);
        $group->post('/calendar/add', \App\Action\Calendar\AddEventAction::class);
        $group->post('/patient/search', \App\Action\Patients\SelectSearchPatAction::class);
        $group->get('/patient/test/comportamento/{user_id}', \App\Action\Reports\WebListComportamentoTestAction::class);
        $group->get('/patient/test/emozioni/{user_id}', \App\Action\Reports\WebListEmozioniTestAction::class);
        $group->get('/patient/test/phq9/{user_id}', \App\Action\Reports\WebPhqTestAction::class);
        $group->get('/patient/report/{user_id}', \App\Action\Reports\WebReportsAction::class);
        $group->get('/doctor/stat', \App\Action\Reports\WebDocStatAction::class);
        $group->post('/dsm/list/search', \App\Action\Dsm\WebDsmSearchByNameAction::class);
        $group->post('/search/patient', \App\Action\Patients\ReportSearchPatAction::class);
        $group->post('/reports/generate', \App\Action\Reports\WebReportGenAction::class);
        $group->post('/consulto/create', \App\Action\Consulti\GeneraLinkConsultoAction::class);
        $group->get('/consulto/list/{paz_id}', \App\Action\Consulti\ListLinkConsultoAction::class);


        /*** END PATIENTS ***/
        $group->post('/doctor/update', \App\Action\Doctors\UpdateDoctorAction::class);
        $group->get('/doctor/calendar',\App\Action\Doctors\UpdateDoctorAction::class);



        $group->get('/cities/list', \App\Action\Cities\ListCitiesAction::class);
        $group->get('/dsm/list', \App\Action\Dsm\ListDsmAction::class);
        $group->get('/pharm/list', \App\Action\Pharm\ListPharmAction::class);
        $group->get('/pharm/list/select', \App\Action\Pharm\ListPharmSelectAction::class);
        /**
         * Retrieve User information
         */
        $group->get('/user/detail/{id}', \App\Action\Users\UserReadAction::class);

        /**
         * Delete user
         */
        $group->get('/user/delete/{id}', \App\Action\Users\UserDeleteAction::class);

        /**
         * List all users
         */
        $group->get('/user/list', \App\Action\Users\UserFindAction::class);

        /**
         * Add User
         */
        $group->post('/user/add', \App\Action\Users\UserCreateAction::class);

        /**
         * Update User
         */
        $group->post('/user/update', \App\Action\Users\UserUpdateAction::class);

        $group->post('/user/password/update', \App\Action\Users\UserPasswordChange::class);

        /********* END USER SECTION ************/

    })->add(UserAuthMiddleware::class);

    $app->group('/mobile/api', function (RouteCollectorProxy $group) {
        $group->post('/mood', \App\Action\Moods\AddMoodAction::class);
        $group->get('/mood/delete/{mood_id}', \App\Action\Moods\DeleteMoodAction::class);
        $group->get('/last_10_mood', \App\Action\Moods\ListMoodAction::class);
        $group->get('/last_10_mood/graph', \App\Action\Moods\ListMoodGraphAction::class);
        $group->post('/patient/update', \App\Action\Users\UserUpdateAction::class);
        $group->post('/patient/update/address', \App\Action\Users\UserUpdateAddrAction::class);
        $group->post('/invite/doctor', \App\Action\Doctors\InviteDoctorAction::class);
        $group->get('/patient/my_doctor', \App\Action\Doctors\DocDetailAppAction::class);
        $group->get('/patient/scollega_doc', \App\Action\Doctors\DocRemoveAction::class);
        $group->get('/patient/delete_account', \App\Action\Users\UserDeleteAction::class);
        $group->get('/drugs/list', \App\Action\Pharm\MobileListPharmAction::class);
        $group->get('/drugs/list/search/{drug_name}', \App\Action\Pharm\SearchByNameAction::class);
        $group->get('/patient/diary', \App\Action\Diary\GetDiaryAction::class);
        $group->post('/patient/diary', \App\Action\Diary\UploadDiaryAction::class);
        $group->get('/patient/diary/delete/{diary_id}', \App\Action\Diary\DeleteDiaryAction::class);
        $group->post('/patient/file/upload', \App\Action\Files\FileUploadAction::class);
        $group->get('/patient/file/list', \App\Action\Files\FileListAction::class);
        $group->post('/patient/file/download', \App\Action\Files\FileDownloadAction::class);
        $group->post('/patient/tracking', \App\Action\Users\UserTrackAction::class);
        $group->get('/patient/tracking/list', \App\Action\Users\UserTrackListAction::class);
        $group->get('/patient/calendar', \App\Action\Users\UserCalendarAction::class);
        $group->get('/patient/drug/list', \App\Action\Patients\ListPharmPatientMobAction::class);
        $group->get('/patient/drug/delete/{id}', \App\Action\Pharm\DeletePharmAction::class);
        $group->post('/patient/drug/add', \App\Action\Pharm\AddPharmAction::class);
        $group->get('/patient/account/delete', \App\Action\Users\UserDeleteAction::class);
        $group->get('/patient/account/download', \App\Action\Users\UserDownloadAction::class);
        $group->post('/obiettivi/add', \App\Action\Obiettivi\AddObiettivoAction::class);
        $group->post('/obiettivi/delete', \App\Action\Obiettivi\DeleteObiettivoAction::class);
        $group->post('/obiettivi/update', \App\Action\Obiettivi\UpdateObiettivoAction::class);
        $group->get('/obiettivi/list', \App\Action\Obiettivi\ListObiettivoAction::class);
        $group->get('/patient/report/pills', \App\Action\Reports\ReportGenAction::class);
        $group->post('/patient/report/mood', \App\Action\Reports\ReportMoodGenAction::class);
        $group->post('/patient/test/comportamento', \App\Action\Reports\ComportamentoTestAction::class);
        $group->get('/patient/test/comportamento', \App\Action\Reports\ListComportamentoTestAction::class);
        $group->post('/patient/test/emozioni', \App\Action\Reports\EmozioniTestAction::class);
        $group->get('/patient/test/emozioni', \App\Action\Reports\ListEmozioniTestAction::class);
        $group->post('/patient/health/passi', \App\Action\Health\AddPassiAction::class);
        $group->post('/patient/test/phq', \App\Action\Reports\Phq9TestAction::class);
        $group->get('/patient/test/phq', \App\Action\Reports\ListPhq9TestAction::class);
        $group->post('/register/notification', \App\Action\Notification\RegisterNotificationAction::class);


    })->add(\App\Middleware\JwtAuthMiddleware::class);


    /** NON ELIMINARE, RISOLVE PROBLEMA PRE-FLIGHT */
    $app->options('/mobile/api/mood', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/mood/delete/{mood_id}', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/last_10_mood', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/last_10_mood/graph', \App\CORS\CORSAction::class);
    $app->options('/register_paz', \App\CORS\CORSAction::class);
    $app->options('/user_login', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/update', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/update/address', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/invite/doctor', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/my_doctor', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/scollega_doc', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/delete_account', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/drugs/list', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/drugs/list/search/{drug_name}', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/diary', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/diary/delete/{diary_id}', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/file/upload', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/file/list', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/file/download', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/tracking', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/tracking/list', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/calendar', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/drug/list', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/drug/delete/{id}', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/drug/add', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/account/delete', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/account/download', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/obiettivi/add', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/obiettivi/delete', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/obiettivi/update', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/obiettivi/list', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/report/pills', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/report/mood', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/test/comportamento', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/test/emozioni', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/health/passi', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/patient/test/phq', \App\CORS\CORSAction::class);
    $app->options('/mobile/api/register/notification', \App\CORS\CORSAction::class);


};
