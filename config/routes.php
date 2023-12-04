<?php

use App\Action\Auth\DocLoginSubmitAction;
use App\Action\Auth\LogoutAction;
use App\Action\Auth\UserLoginSubmitAction;
use App\Action\Calendar\AddEventAction;
use App\Action\Calendar\ListEventAction;
use App\Action\Cities\ListCitiesAction;
use App\Action\Consulti\GenerateConsultLinkAction;
use App\Action\Consulti\ListConsultLinkAction;
use App\Action\Consulti\PinCodeActionCheck;
use App\Action\Diary\DeleteDiaryAction;
use App\Action\Diary\GetDiaryAction;
use App\Action\Diary\UploadDiaryAction;
use App\Action\Doctors\DocDetailAppAction;
use App\Action\Doctors\DocRemoveAction;
use App\Action\Doctors\InviteDoctorAction;
use App\Action\Doctors\UpdateDoctorAction;
use App\Action\Dsm\ListDsmAction;
use App\Action\Dsm\WebDsmSearchByNameAction;
use App\Action\Files\DocFileDeleteAction;
use App\Action\Files\DocFileDownloadAction;
use App\Action\Files\DocFileListAction;
use App\Action\Files\DocFileUploadAction;
use App\Action\Files\FileDownloadAction;
use App\Action\Files\FileListAction;
use App\Action\Files\FileUploadAction;
use App\Action\Health\AddStepsAction;
use App\Action\Home\HomeAction;
use App\Action\Invoices\ListInvoiceAction;
use App\Action\Messages\ListContactsAction;
use App\Action\Moods\AddMoodAction;
use App\Action\Moods\DeleteMoodAction;
use App\Action\Moods\ListMoodAction;
use App\Action\Moods\ListMoodGraphAction;
use App\Action\Notification\RegisterNotificationAction;
use App\Action\Obiettivi\AddObjectiveAction;
use App\Action\Obiettivi\DeleteObjectiveAction;
use App\Action\Obiettivi\ListObjectiveAction;
use App\Action\Obiettivi\UpdateObjectiveAction;
use App\Action\OpenApi\Version1DocAction;
use App\Action\Pages\AddPatientsAction;
use App\Action\Pages\AdminLoginPageAction;
use App\Action\Pages\CalendarAction;
use App\Action\Pages\ConsultoPageAction;
use App\Action\Pages\CreateCheckoutSession;
use App\Action\Pages\DetailDocPageAction;
use App\Action\Pages\DocLoginPageAction;
use App\Action\Pages\FaqPageAction;
use App\Action\Pages\HomeDocPageAction;
use App\Action\Pages\ListSmartboxAction;
use App\Action\Pages\MessagesDocPageAction;
use App\Action\Pages\PatientDetailAction;
use App\Action\Pages\PazLoginPageAction;
use App\Action\Pages\PrivacyPageAction;
use App\Action\Pages\RegisterDocPageAction;
use App\Action\Pages\ReportsAction;
use App\Action\Pages\TermsPageAction;
use App\Action\Patients\AddAnnotationPatientAction;
use App\Action\Patients\AddPatientAction;
use App\Action\Patients\AddPillPatientAction;
use App\Action\Patients\DeleteAnnotationPatientAction;
use App\Action\Patients\DelPatientAction;
use App\Action\Patients\DelPillPatientAction;
use App\Action\Patients\List10MoodPatientAction;
use App\Action\Patients\ListAllDeprePatientAction;
use App\Action\Patients\ListAllMoodPatientAction;
use App\Action\Patients\ListAnnotationPatientAction;
use App\Action\Patients\ListDiaryPatientAction;
use App\Action\Patients\ListPatAction;
use App\Action\Patients\ListPharmPatientAction;
use App\Action\Patients\ListPharmPatientMobAction;
use App\Action\Patients\LoadPatientRelationAction;
use App\Action\Patients\ReportSearchPatAction;
use App\Action\Patients\SavePatientRelationAction;
use App\Action\Patients\SearchPatAction;
use App\Action\Patients\SelectSearchPatAction;
use App\Action\Patients\UpdatePatientAction;
use App\Action\Pharm\AddPharmAction;
use App\Action\Pharm\DeletePharmAction;
use App\Action\Pharm\ListPharmAction;
use App\Action\Pharm\ListPharmSelectAction;
use App\Action\Pharm\MobileListPharmAction;
use App\Action\Pharm\SearchByNameAction;
use App\Action\Pharm\WebSearchByNameAction;
use App\Action\Reports\BehaviourTestAction;
use App\Action\Reports\EmotionsTestAction;
use App\Action\Reports\ListBehaviourTestAction;
use App\Action\Reports\ListEmotionsTestAction;
use App\Action\Reports\ListPhq9TestAction;
use App\Action\Reports\Phq9TestAction;
use App\Action\Reports\ReportGenAction;
use App\Action\Reports\ReportMoodGenAction;
use App\Action\Reports\WebDocStatAction;
use App\Action\Reports\WebListComportamentoTestAction;
use App\Action\Reports\WebListEmozioniTestAction;
use App\Action\Reports\WebPhqTestAction;
use App\Action\Reports\WebReportGenAction;
use App\Action\Reports\WebReportsAction;
use App\Action\Security\HackAttemptAction;
use App\Action\Stripe\webhook;
use App\Action\Users\UserCalendarAction;
use App\Action\Users\UserCreateAction;
use App\Action\Users\UserCreateDocAction;
use App\Action\Users\UserCreatePazAction;
use App\Action\Users\UserDeleteAction;
use App\Action\Users\UserDocDeleteAction;
use App\Action\Users\UserDownloadAction;
use App\Action\Users\UserFindAction;
use App\Action\Users\UserHistoryAction;
use App\Action\Users\UserPasswordChange;
use App\Action\Users\UserReadAction;
use App\Action\Users\UserTrackAction;
use App\Action\Users\UserTrackListAction;
use App\Action\Users\UserUpdateAction;
use App\Action\Users\UserUpdateAddrAction;
use App\CORS\CORSAction;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\UserAuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Redirect to Swagger documentation
    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/whatsapp', HomeAction::class)->setName('whatsapp');
    // Swagger API documentation
    $app->get('/docs/v1', Version1DocAction::class)->setName('docs');

    $app->post('/doc_login', DocLoginSubmitAction::class)->setName('login');

    $app->post('/user_login', UserLoginSubmitAction::class)->setName('user-login');

    $app->post('/register_doc', UserCreateDocAction::class);

    $app->post('/register_paz', UserCreatePazAction::class);

    $app->get('/logout', LogoutAction::class);


    $app->group('/public', function (RouteCollectorProxy $group) {
        $group->get("/doc_login", DocLoginPageAction::class)->setName('public_doc_login');
        $group->get("/paziente_login", PazLoginPageAction::class)->setName('public_paz_login');
        $group->get("/admin_login", AdminLoginPageAction::class)->setName('public_admin_login');
        $group->get("/register_doc", RegisterDocPageAction::class)->setName('register_doc');
        $group->get("/privacy", PrivacyPageAction::class)->setName('privacy-policy');
        $group->get("/terms", TermsPageAction::class)->setName('terms');
        $group->post("/stripe/webhook", webhook::class)->setName('wh');
        $group->get("/consult/{codice}", ConsultoPageAction::class)->setName('consult');
        $group->post("/pincode/check", PinCodeActionCheck::class)->setName('consult-pin-check');
        $group->post("/hack/attempt", HackAttemptAction::class)->setName('log-hack-attempt');
        $group->get('/create-checkout-session', CreateCheckoutSession::class)->setName('payment-page');
    });

    $app->group('/pages', function (RouteCollectorProxy $group) {
        $group->get("/home_doctor", HomeDocPageAction::class)->setName('pages-home-doc');
        $group->get("/doctor_detail[/{esito}]", DetailDocPageAction::class)->setName('doctor-detail');
        $group->get("/messages", MessagesDocPageAction::class)->setName('doctor-detail');
        $group->get("/patients/detail/{paz_id}", PatientDetailAction::class)->setName('pages-view-patient');
        $group->get("/calendar", CalendarAction::class)->setName('calendar');
        $group->get("/reports", ReportsAction::class)->setName('reports');
        $group->get("/faq", FaqPageAction::class)->setName('reports');

        $group->get("/patients/add", AddPatientsAction::class)->setName('add-patient');
        $group->get("/patients/list", ListSmartboxAction::class)->setName('list-patient');
    })->add(UserAuthMiddleware::class);

    // API endpoints. This group is protected with JWT.
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/patients/add', AddPatientAction::class);
        $group->get('/patients/list', ListPatAction::class);
        $group->get('/patients/list/last_10_mood/{paz_id}', List10MoodPatientAction::class);
        $group->get('/patients/list/diary/{user_id}', ListDiaryPatientAction::class);
        $group->get('/patients/pharm/list/{paz_id}', ListPharmPatientAction::class);
        $group->post('/patients/update', UpdatePatientAction::class);
        $group->get('/patients/file/list/{user_id}', DocFileListAction::class);
        $group->post('/patient/file/download', DocFileDownloadAction::class);
        $group->post('/patient/file/upload', DocFileUploadAction::class);
        $group->post('/patient/file/delete', DocFileDeleteAction::class);
        $group->get('/patient/mood/all/{user_id}', ListAllMoodPatientAction::class);
        $group->get('/patient/depressione/all/{user_id}', ListAllDeprePatientAction::class);
        $group->get('/account/delete', UserDocDeleteAction::class);
        $group->get('/login/history', UserHistoryAction::class);
        $group->post('/password/update', UserPasswordChange::class);
        $group->post('/drugs/list/search', WebSearchByNameAction::class);
        $group->get('/search/patient/{full_name}', SearchPatAction::class);
        $group->get('/invoices/list', ListInvoiceAction::class);
        $group->get('/patient/pills/add/{paz_id}/{pill_id}', AddPillPatientAction::class);
        $group->get('/patient/pills/delete/{paz_id}/{ass_id}', DelPillPatientAction::class);
        $group->get('/patient/delete/{paz_id}', DelPatientAction::class);
        $group->get('/patients/list/annotation/{paz_id}', ListAnnotationPatientAction::class);
        $group->post('/patients/add/annotation', AddAnnotationPatientAction::class);
        $group->get('/patients/delete/annotation/{ann_id}', DeleteAnnotationPatientAction::class);
        $group->get('/patients/relazione/{paz_id}', LoadPatientRelationAction::class);
        $group->post('/patients/relazione/save', SavePatientRelationAction::class);
        $group->get('/patient/messsages/contacts', ListContactsAction::class);
        $group->get('/calendar/list', ListEventAction::class);
        $group->post('/calendar/add', AddEventAction::class);
        $group->post('/patient/search', SelectSearchPatAction::class);
        $group->get('/patient/test/comportamento/{user_id}', WebListComportamentoTestAction::class);
        $group->get('/patient/test/emozioni/{user_id}', WebListEmozioniTestAction::class);
        $group->get('/patient/test/phq9/{user_id}', WebPhqTestAction::class);
        $group->get('/patient/report/{user_id}', WebReportsAction::class);
        $group->get('/doctor/stat', WebDocStatAction::class);
        $group->post('/dsm/list/search', WebDsmSearchByNameAction::class);
        $group->post('/search/patient', ReportSearchPatAction::class);
        $group->post('/reports/generate', WebReportGenAction::class);
        $group->post('/consult/create', GenerateConsultLinkAction::class);
        $group->get('/consult/list/{paz_id}', ListConsultLinkAction::class);


        /*** END PATIENTS ***/
        $group->post('/doctor/update', UpdateDoctorAction::class);
        $group->get('/doctor/calendar', UpdateDoctorAction::class);


        $group->get('/cities/list', ListCitiesAction::class);
        $group->get('/dsm/list', ListDsmAction::class);
        $group->get('/pharm/list', ListPharmAction::class);
        $group->get('/pharm/list/select', ListPharmSelectAction::class);
        /**
         * Retrieve User information
         */
        $group->get('/user/detail/{id}', UserReadAction::class);

        /**
         * Delete user
         */
        $group->get('/user/delete/{id}', UserDeleteAction::class);

        /**
         * List all users
         */
        $group->get('/user/list', UserFindAction::class);

        /**
         * Add User
         */
        $group->post('/user/add', UserCreateAction::class);

        /**
         * Update User
         */
        $group->post('/user/update', UserUpdateAction::class);

        $group->post('/user/password/update', UserPasswordChange::class);

        /********* END USER SECTION ************/
    })->add(UserAuthMiddleware::class);

    $app->group('/mobile/api', function (RouteCollectorProxy $group) {
        $group->post('/mood', AddMoodAction::class);
        $group->get('/mood/delete/{mood_id}', DeleteMoodAction::class);
        $group->get('/last_10_mood', ListMoodAction::class);
        $group->get('/last_10_mood/graph', ListMoodGraphAction::class);
        $group->post('/patient/update', UserUpdateAction::class);
        $group->post('/patient/update/address', UserUpdateAddrAction::class);
        $group->post('/invite/doctor', InviteDoctorAction::class);
        $group->get('/patient/my_doctor', DocDetailAppAction::class);
        $group->get('/patient/scollega_doc', DocRemoveAction::class);
        $group->get('/patient/delete_account', UserDeleteAction::class);
        $group->get('/drugs/list', MobileListPharmAction::class);
        $group->get('/drugs/list/search/{drug_name}', SearchByNameAction::class);
        $group->get('/patient/diary', GetDiaryAction::class);
        $group->post('/patient/diary', UploadDiaryAction::class);
        $group->get('/patient/diary/delete/{diary_id}', DeleteDiaryAction::class);
        $group->post('/patient/file/upload', FileUploadAction::class);
        $group->get('/patient/file/list', FileListAction::class);
        $group->post('/patient/file/download', FileDownloadAction::class);
        $group->post('/patient/tracking', UserTrackAction::class);
        $group->get('/patient/tracking/list', UserTrackListAction::class);
        $group->get('/patient/calendar', UserCalendarAction::class);
        $group->get('/patient/drug/list', ListPharmPatientMobAction::class);
        $group->get('/patient/drug/delete/{id}', DeletePharmAction::class);
        $group->post('/patient/drug/add', AddPharmAction::class);
        $group->get('/patient/account/delete', UserDeleteAction::class);
        $group->get('/patient/account/download', UserDownloadAction::class);
        $group->post('/obiettivi/add', AddObjectiveAction::class);
        $group->post('/obiettivi/delete', DeleteObjectiveAction::class);
        $group->post('/obiettivi/update', UpdateObjectiveAction::class);
        $group->get('/obiettivi/list', ListObjectiveAction::class);
        $group->get('/patient/report/pills', ReportGenAction::class);
        $group->post('/patient/report/mood', ReportMoodGenAction::class);
        $group->post('/patient/test/comportamento', BehaviourTestAction::class);
        $group->get('/patient/test/comportamento', ListBehaviourTestAction::class);
        $group->post('/patient/test/emozioni', EmotionsTestAction::class);
        $group->get('/patient/test/emozioni', ListEmotionsTestAction::class);
        $group->post('/patient/health/passi', AddStepsAction::class);
        $group->post('/patient/test/phq', Phq9TestAction::class);
        $group->get('/patient/test/phq', ListPhq9TestAction::class);
        $group->post('/register/notification', RegisterNotificationAction::class);
    })->add(JwtAuthMiddleware::class);


    /**
     * WARNING !
     * DO NOT remove the following lines.
     * Those lines resolve the problem on the app
     * for the PRE-FLIGHT problem.
     * @note To each new endpoint (get or post) must be created
     * also here in OPTIONS mode.
     */
    $app->options('/mobile/api/mood', CORSAction::class);
    $app->options('/mobile/api/mood/delete/{mood_id}', CORSAction::class);
    $app->options('/mobile/api/last_10_mood', CORSAction::class);
    $app->options('/mobile/api/last_10_mood/graph', CORSAction::class);
    $app->options('/register_paz', CORSAction::class);
    $app->options('/user_login', CORSAction::class);
    $app->options('/mobile/api/patient/update', CORSAction::class);
    $app->options('/mobile/api/patient/update/address', CORSAction::class);
    $app->options('/mobile/api/invite/doctor', CORSAction::class);
    $app->options('/mobile/api/patient/my_doctor', CORSAction::class);
    $app->options('/mobile/api/patient/scollega_doc', CORSAction::class);
    $app->options('/mobile/api/patient/delete_account', CORSAction::class);
    $app->options('/mobile/api/drugs/list', CORSAction::class);
    $app->options('/mobile/api/drugs/list/search/{drug_name}', CORSAction::class);
    $app->options('/mobile/api/patient/diary', CORSAction::class);
    $app->options('/mobile/api/patient/diary/delete/{diary_id}', CORSAction::class);
    $app->options('/mobile/api/patient/file/upload', CORSAction::class);
    $app->options('/mobile/api/patient/file/list', CORSAction::class);
    $app->options('/mobile/api/patient/file/download', CORSAction::class);
    $app->options('/mobile/api/patient/tracking', CORSAction::class);
    $app->options('/mobile/api/patient/tracking/list', CORSAction::class);
    $app->options('/mobile/api/patient/calendar', CORSAction::class);
    $app->options('/mobile/api/patient/drug/list', CORSAction::class);
    $app->options('/mobile/api/patient/drug/delete/{id}', CORSAction::class);
    $app->options('/mobile/api/patient/drug/add', CORSAction::class);
    $app->options('/mobile/api/patient/account/delete', CORSAction::class);
    $app->options('/mobile/api/patient/account/download', CORSAction::class);
    $app->options('/mobile/api/obiettivi/add', CORSAction::class);
    $app->options('/mobile/api/obiettivi/delete', CORSAction::class);
    $app->options('/mobile/api/obiettivi/update', CORSAction::class);
    $app->options('/mobile/api/obiettivi/list', CORSAction::class);
    $app->options('/mobile/api/patient/report/pills', CORSAction::class);
    $app->options('/mobile/api/patient/report/mood', CORSAction::class);
    $app->options('/mobile/api/patient/test/comportamento', CORSAction::class);
    $app->options('/mobile/api/patient/test/emozioni', CORSAction::class);
    $app->options('/mobile/api/patient/health/passi', CORSAction::class);
    $app->options('/mobile/api/patient/test/phq', CORSAction::class);
    $app->options('/mobile/api/register/notification', CORSAction::class);
};
