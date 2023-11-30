<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="app-user-view-account">
                <div class="row">
                    <!-- User Sidebar -->
                    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                        <!-- User Card -->
                        <div class="card">
                            <div class="card-body">
                                <div class="user-avatar-section">
                                    <div class="d-flex align-items-center flex-column">
                                        <img class="img-fluid rounded mt-3 mb-2"
                                             src="<?php echo get_gravatar($email) ?? '/app-assets/images/portrait/small/avatar-s-2.jpg' ?>"
                                             height="110" width="110" alt="User avatar"/>
                                        <div class="user-info text-center">
                                            <h4><?php echo $name . " " . $surname; ?></h4>
                                            <span class="badge bg-light-secondary"><?php echo $cf ?? __('C.F. non settato'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around my-2 pt-75">
                                     <div class="d-flex align-items-start me-2">
                                             <span class="badge bg-light-primary p-75 rounded">
                                                 <i data-feather="activity" class="font-medium-2"></i>
                                             </span>
                                         <div class="ms-75">
                                             <h4 class="mb-0"><?php echo $tot_passi ?? 0;?></h4>
                                             <small><?php echo __("Passi Effettuati Oggi"); ?></small>
                                         </div>
                                     </div>
                                     <div class="d-flex align-items-start">
                                             <span class="badge bg-light-primary p-75 rounded">
                                                 <i data-feather="file-text" class="font-medium-2"></i>
                                             </span>
                                         <div class="ms-75">
                                             <h4 class="mb-0"><?php echo $tot_post ?? 0;?></h4>
                                             <small><?php echo __("Post Creati"); ?></small>
                                         </div>
                                     </div>
                                 </div>
                                <h4 class="fw-bolder border-bottom pb-50 mb-1"><?php echo __("Dettagli"); ?></h4>
                                <div class="info-container">
                                    <ul class="list-unstyled">
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Codice Utente"); ?></span>
                                            <span id="paz_id"><?php echo $paz_id; ?></span>-<span
                                                    id="user_id"><?php echo $user_id; ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Diagnosi"); ?></span>
                                            <span><?php echo $icd_ten . " <span id='desc_dsm'>" . $descrizione . "</span>"; ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Indirizzo E-Mail") ?></span>
                                            <span><?php echo $email ?? __('E-Mail non registrata'); ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Cellulare"); ?></span>
                                            <span><?php echo $telefono ?? __('Telefono non inserito'); ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Contatto di Emergenza"); ?></span>
                                            <span><?php echo $em_nome . " " . $em_telefono; ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Indirizzo Completo"); ?></span>
                                            <span><?php echo $address; ?></span>
                                        </li>
                                    </ul>
                                    <div class="d-flex justify-content-center pt-2">
                                        <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser"
                                           data-bs-toggle="modal">
                                            <?php echo __("Modifica"); ?>
                                        </a>
                                        <a onclick="delete_patient();" class="btn btn-outline-danger suspend-user me-1"><?php echo __("Elimina"); ?></a>
                                        <a data-bs-target="#modalConsulto" data-bs-toggle="modal" class="btn btn-warning me-1"><?php echo __("Consulto"); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /User Card -->
                    </div>
                    <!--/ User Sidebar -->

                    <!-- User Content -->
                    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                        <!-- User Pills -->
                        <ul class="nav nav-pills mb-2">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="pill" href="#home"
                                   aria-expanded="true">
                                    <i data-feather="user" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold"><?php echo __("Dati Base Paziente"); ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#diario_paziente" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="lock" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold"><?php echo __("Diario del Paziente"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#drive" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="hard-drive" class="font-medium-3 me-50"></i>
                                    <span class="fw-bold"><?php echo __("Documenti Condivisi"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#reports" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="bell" class="font-medium-3 me-50"></i><span
                                            class="fw-bold"><?php echo __("Report"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#annotazioni" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="file-plus" class="font-medium-3 me-50"></i><span class="fw-bold"><?php echo __("Annotazioni"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#relazione" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="clipboard" class="font-medium-3 me-50"></i><span class="fw-bold"><?php echo __("Relazione"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#test" data-bs-toggle="pill" aria-expanded="false">
                                    <i data-feather="box" class="font-medium-3 me-50"></i><span class="fw-bold"><?php echo __("Test"); ?></span>
                                </a>
                            </li>
                        </ul>
                        <!--/ User Pills -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home" aria-labelledby="home-tab" aria-expanded="true">
                                <div class="card">
                                    <h4 class="card-header"><?php echo __("Trattamento Farmacologico"); ?></h4>
                                    <div class="table-responsive">
                                        <table class="table datatable-project" id="tbl_trattamento_farmacologico">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th><?php echo __("Molecola"); ?></th>
                                                <th class="text-nowrap"><?php echo __("Nome Farmaco"); ?></th>
                                                <th><?php echo __("Azioni"); ?></th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- /Project table -->

                                <!-- Activity Timeline -->
                                <div class="card">
                                    <h4 class="card-header"><?php echo __("Ultime 10 registrazioni Umore"); ?></h4>
                                    <div class="card-body pt-1" id="list-container">
                                        <ul class="timeline ms-50">
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Activity Timeline -->

                                <!-- Invoice table
                                <div class="card">
                                    <table class="invoice-table table text-nowrap" id="tbl_fatture">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>#ID</th>
                                            <th>TOTALE Pagato</th>
                                            <th class="text-truncate">Data Fatturazione</th>
                                            <th class="cell-fit">Azioni</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div> -->
                                <!-- /Invoice table -->
                            </div>

                            <div class="tab-pane" id="diario_paziente" role="tabpanel" aria-labelledby="security" aria-expanded="false">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title"><?php echo __("Il Suo Diario"); ?></h4>
                                    </div>
                                    <div class="card-body pt-1">
                                        <div class="accordion accordion-margin mt-2" id="diary-holder">
                                        </div>
                                    </div>
                                    </div>
                                </div>

                            <div class="tab-pane" id="drive" role="tabpanel" aria-labelledby="drive" aria-expanded="false">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title"><?php echo __("File Condivisi"); ?></h4>
                                    </div>
                                    <div class="card-body pt-1">
                                        <ul id="file_list" class="list-group list-group-flush">

                                        </ul>
                                    </div>
                                    <div class="card-footer">
                                        <input type="file" name="file" id="file" class="form-control inline"><br>
                                        <a class="btn btn-success" onclick="uploadFile();"><?php echo __("CARICA FILE"); ?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="reports" role="tabpanel" aria-labelledby="reports" aria-expanded="false">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Grafico Umore"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <canvas class="doughnut-chart" id="myChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Grafico Andamento Depressione"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <canvas class="bar-chart" id="myDepressionChart"></canvas>
                                            </div>
                                            <div class="card-footer">
                                                <?php echo __("5-9 = Sintomi depressivi minimi / Depressione sottosoglia"); ?><br>
                                                <?php echo __("10-14 = Depressione minore / Depressione maggiore lieve"); ?><br>
                                                <?php echo __("15-19 = Depressione maggiore moderata"); ?><br>
                                                <?php echo __("≥ 20 = Depressione maggiore severa"); ?><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Statistiche (Ultimi 7 Giorni)"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div id="stat_patient"><?php echo __("Caricamento in corso"); ?></div>
                                            </div>
                                            <div class="card-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="annotazioni" role="tabpanel" aria-labelledby="annotazioni" aria-expanded="false">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Elenco Annotazioni"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="accordion accordion-margin mt-2" id="annotazioni-holder">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Nuova Annotazione"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <textarea class="form-control" id="nuova_annotazione" name="nuova_annotazione"></textarea>
                                            </div>
                                            <div class="card-footer">
                                                <a onclick="salvaAnnotazione();" class="btn btn-success">SALVA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="relazione" role="tabpanel" aria-labelledby="relazione" aria-expanded="false">
                                <div class="row">
                                    <form>
                                        <div class="row" id="snow_container">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div id="snow-wrapper">
                                                                    <div id="snow-container">
                                                                        <div class="quill-toolbar">
                                                        <span class="ql-formats">
                                                            <select class="ql-header">
                                                                <option value="1">Heading</option>
                                                                <option value="2">Subheading</option>
                                                                <option selected>Normal</option>
                                                            </select>
                                                            <select class="ql-font">
                                                                <option selected>Sailec Light</option>
                                                                <option value="sofia">Sofia Pro</option>
                                                                <option value="slabo">Slabo 27px</option>
                                                                <option value="roboto">Roboto Slab</option>
                                                                <option value="inconsolata">Inconsolata</option>
                                                                <option value="ubuntu">Ubuntu Mono</option>
                                                            </select>
                                                        </span>
                                                                            <span class="ql-formats">
                                                            <button class="ql-bold"></button>
                                                            <button class="ql-italic"></button>
                                                            <button class="ql-underline"></button>
                                                        </span>
                                                                            <span class="ql-formats">
                                                            <button class="ql-list" value="ordered"></button>
                                                            <button class="ql-list" value="bullet"></button>
                                                        </span>
                                                                            <span class="ql-formats">
                                                            <button class="ql-link"></button>
                                                            <button class="ql-image"></button>
                                                            <button class="ql-video"></button>
                                                        </span>
                                                                            <span class="ql-formats">
                                                            <button class="ql-formula"></button>
                                                            <button class="ql-code-block"></button>
                                                        </span>
                                                                            <span class="ql-formats">
                                                            <button class="ql-clean"></button>
                                                        </span>
                                                                        </div>
                                                                        <div class="editor" id="editor">
                                                                            <h1 class="ql-align-center">Relazione su Paziente</h1>
                                                                            <p class="card-text"><br /></p>
                                                                            <p class="card-text">
                                                                                <?php echo __("Caricamento in corso....."); ?>
                                                                            </p>
                                                                            <p class="card-text"><br /></p>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <a onclick="salvaRelazione()" clasS="btn btn-success"><?php echo __("SALVA RELAZIONE"); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane" id="test" role="tabpanel" aria-labelledby="test" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Esito dei Test"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <h3><?php echo __("PHQ-9 (Depressione)"); ?></h3>
                                                <div class="accordion accordion-margin mt-2" id="phq9-holder">
                                                    <?php echo __("Ancora Nulla"); ?>
                                                </div>
                                                <br>
                                                <h3><?php echo __("Comportamenti Impulsivi"); ?></h3>
                                                <div class="accordion accordion-margin mt-2" id="comportamenti-holder">
                                                    <?php echo __("Ancora Nulla"); ?>
                                                </div>
                                                <br>
                                               <h3><?php echo __("Emozioni"); ?></h3>
                                                <div class="accordion accordion-margin mt-2" id="emozioni-holder">
                                                    <?php echo __("Ancora Nulla"); ?>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Sottoponi Test"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <ul>
                                                    <li>SCID-5</li>
                                                    <li><?php echo __("Depressione"); ?></li>
                                                </ul>
                                                <br>
                                                <?php echo __("Test selezionato:");?> <span id="selected_test"></span>
                                            </div>
                                            <div class="card-footer">
                                                <button class="btn btn-success" disabled><?php echo __("Invia Test"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
        </section>
            <!-- Edit User Modal -->
            <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                    <div class="modal-content">
                        <div class="modal-header bg-transparent">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pb-5 px-sm-5 pt-50">
                            <div class="text-center mb-2">
                                <h1 class="mb-1"><?php echo __("Modifica informazioni Paziente"); ?></h1>
                                <p><?php echo __("Attenzione ! Indietro non si torna !"); ?></p>
                            </div>
                            <form id="editUserForm" class="row gy-1 pt-75" onsubmit="return false">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserFirstName"><?php echo __("Nome"); ?></label>
                                    <input type="text" id="modalEditUserFirstName" name="modalEditUserFirstName"
                                           class="form-control" placeholder="Marco" value="<?php echo $name; ?>"
                                           data-msg="Perfavore inserisci nome"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserLastName"><?php echo __("Cognome"); ?></label>
                                    <input type="text" id="modalEditUserLastName" name="modalEditUserLastName"
                                           class="form-control" placeholder="Rossi" value="<?php echo $surname; ?>"
                                           data-msg="Perfavore inserisci Cognome"/>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="modalEditUserName"><?php echo __("Codice Fiscale"); ?></label>
                                    <input type="text" id="modalEditUserName" name="modalEditUserName"
                                           class="form-control" value="<?php echo $cf; ?>"
                                           placeholder="RSSMRC89S28F839C"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserEmail"><?php echo __("Indirizzo Email:"); ?></label>
                                    <input type="text" id="modalEditUserEmail" name="modalEditUserEmail"
                                           class="form-control" value="<?php echo $email; ?>"
                                           placeholder="example@domain.com"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserTel"><?php echo __("Cellulare"); ?></label>
                                    <input type="text" id="modalEditUserTel" name="modalEditUserTel"
                                           class="form-control" value="<?php echo $telefono; ?>"
                                           placeholder="3331236547"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditEmNome"><?php echo __("Contatto di Emergenza"); ?></label>
                                    <input type="text" id="modalEditEmNome" name="modalEditEmNome" class="form-control"
                                           placeholder="Rossi Manuala" value="<?php echo $em_nome; ?>"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditEmPhone"><?php echo __("Numero Contatto di Emergenza"); ?></label>
                                    <input type="text" id="modalEditEmPhone" name="modalEditEmPhone"
                                           class="form-control phone-number-mask" placeholder="+39 333 1235 402"
                                           value="<?php echo $em_telefono; ?>"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserIndirizzo"><?php echo __("Indirizzo"); ?></label>
                                    <input type="text" id="modalEditUserIndirizzo" name="modalEditUserIndirizzo"
                                           class="form-control phone-number-mask"
                                           placeholder="Via Leonardo da Vinci, 90, San Nicola la Strada, Caserta"
                                           value="<?php echo $address; ?>"/>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="modalEditUserDsm"><?php echo __("Diagnosi"); ?></label>
                                    <select id="modalEditUserDsm" name="modalEditUserDsm[]" class="select2 form-select" multiple>
                                    </select>
                                </div>
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button type="submit" class="btn btn-primary me-1" onclick="update_patient_info();">
<?php echo __("Aggiorna") ?>
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
<?php echo __("Annulla"); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Edit User Modal -->
            <div class="modal modal-slide-in fade" id="modals-add-pharm">
                <div class="modal-dialog sidebar-sm">
                    <form class="add-new-record-pharm modal-content pt-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel"><?php echo __("Aggiunta Farmaco"); ?></h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label" for="lista_pharm"><?php echo __("Denominazione"); ?></label>
                                <select class="select2 w-100 js-data-example-ajax" id="lista_pharm" name="lista_pharm">
                                </select>
                            </div>

                            <button type="button" onclick="addDrug();" class="btn btn-primary data-submit me-1"><?php echo __("Aggiungi"); ?></button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo __("Annulla"); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        <div class="modal fade" id="modalConsulto" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1"><?php echo __("Richiesta Consulto"); ?></h1>
                            <p><?php echo __("Qui potrai generare un link valido massimo 48 ore da inviare ad un collega
                            per darti una mano a capire meglio il tuo paziente."); ?></p>
                        </div>
                        <form id="consultoForm" class="row gy-1 pt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="modalEditUserFirstName">E-Mail</label>
                                    <input type="text" id="consultoMail" name="consultoMail" class="form-control" placeholder="nome@email.it" data-msg="Perfavore inserisci e-mail"/><br><br>
                                </div>
                                <br><br>
                                <div id="consultoResult"></div>
                            </div>
                            <div class="row">
                                <hr>
                                <h4><?php echo __("Inviti inviati ancora attivi"); ?></h4>
                                <p>
                                    <ul id="currentConsult">
                                    </ul>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button type="submit" class="btn btn-primary me-1" onclick="richiediConsulto();">
<?php echo __("Invia"); ?>
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">
<?php echo __("Annulla"); ?>
                                    </button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        </div>
    </div>
</div>
<!-- END: Content-->
