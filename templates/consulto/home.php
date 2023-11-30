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
                                             src="/app-assets/images/avatars/no-profile.png" height="110" width="110" alt="User avatar"/>
                                        <div class="user-info text-center">
                                            <h4>Nominativo Nascosto</h4>
                                            <span class="badge bg-light-secondary"><?php echo __("Modalità Privacy ON"); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around my-2 pt-75">
                                    <div class="d-flex align-items-start me-2">
                                             <span class="badge bg-light-primary p-75 rounded">
                                                 <i data-feather="activity" class="font-medium-2"></i>
                                             </span>
                                        <div class="ms-75">
                                            <h4 class="mb-0"><?php echo $patient['tot_passi'] ?? 0;?></h4>
                                            <small><?php echo __("Passi Effettuati Oggi");?></small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                             <span class="badge bg-light-primary p-75 rounded">
                                                 <i data-feather="file-text" class="font-medium-2"></i>
                                             </span>
                                        <div class="ms-75">
                                            <h4 class="mb-0"><?php echo $patient['tot_post'] ?? 0;?></h4>
                                            <small><?php echo __("Post Creati"); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="fw-bolder border-bottom pb-50 mb-1"><?php echo __("Dettagli");?></h4>
                                <div class="info-container">
                                    <ul class="list-unstyled">
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Codice Utente"); ?></span>
                                            <span id="paz_id"><?php echo $patient['paz_id']; ?></span>-<span id="user_id"><?php echo $patient['user_id']; ?></span>
                                        </li>
                                        <li class="mb-75">
                                            <span class="fw-bolder me-25"><?php echo __("Diagnosi"); ?></span>
                                            <span><?php echo $patient['icd_ten'] . " <span id='desc_dsm'>" . $patient['descrizione'] . "</span>"; ?></span>
                                        </li>
                                    </ul>
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
                                    <i data-feather="clipboard" class="font-medium-3 me-50"></i><span class="fw-bold"><?php echo __("Relazione");?></span>
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
                                        <ul>
                                            <?php echo $lista_farmaci;?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Project table -->

                                <!-- Activity Timeline -->
                                <div class="card">
                                    <h4 class="card-header"><?php echo __("Ultime 10 registrazioni Umore"); ?></h4>
                                    <div class="card-body pt-1" id="list-container">
                                        <ul class="timeline ms-50">
                                            <?php echo $registrazioni_mood;?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /Activity Timeline -->

                            </div>

                            <div class="tab-pane" id="diario_paziente" role="tabpanel" aria-labelledby="security" aria-expanded="false">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h4 class="card-title"><?php echo __("Il Suo Diario"); ?></h4>
                                    </div>
                                    <div class="card-body pt-1">
                                        <div class="accordion accordion-margin mt-2" id="diary-holder">
                                            <?php echo $diario;?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="reports" role="tabpanel" aria-labelledby="reports" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Statistiche (Ultimi 7 Giorni)"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <?php
                                                    echo "<h3>" . __("DIARIO") . "</h3>";
                                                    echo $stats['diario'];

                                                    echo "<h3>". __("COMPORTAMENTI")."</h3>";
                                                    echo $stats['comportamento'];

                                                    echo "<h3>". __("EMOZIONI") ."</h3>";
                                                    echo $stats['emozioni_stat'];

                                                    echo "<h3>" . __("MEDIANA EMOZIONI") . "</h3>";
                                                    echo $stats['emozioni_avg'];
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="annotazioni" role="tabpanel" aria-labelledby="annotazioni" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h4 class="card-title"><?php echo __("Elenco Annotazioni"); ?></h4>
                                            </div>
                                            <div class="card-body pt-1">
                                                <div class="accordion accordion-margin mt-2" id="annotazioni-holder2">
                                                    <?php echo $annotazioni; ?>
                                                </div>
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
                                                        <?php echo $patient['notes'];?>
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
                                                <?php echo $phq;?>
                                                <br>
                                                <h3><?php echo __("Comportamenti Impulsivi"); ?></h3>
                                                <?php echo $compImp; ?>
                                                <br>
                                                <h3><?php echo __("Emozioni"); ?></h3>
                                                <div class="accordion accordion-margin mt-2" id="emozioni-holder">
                                                    Ancora Nulla
                                                </div>


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
        <div class="modal fade" id="modalConsulto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1"><?php echo __("Accesso Cartella Assistito"); ?></h1>
                            <p><?php echo __("Perfavore, inserisca il codice di accesso ricevuto via e-mail"); ?></p>
                        </div>
                        <form id="consultoForm" class="row gy-1 pt-75" onsubmit="return false">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <label class="form-label" for="modalEditUserFirstName"><?php echo __("Codice PIN");?></label>
                                    <input type="text" id="codice_sicurezza" class="form-control"/><br><br>
                                </div>
                                <br><br>
                                <div id="consultoResult"></div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center mt-2 pt-50">
                                    <button type="submit" class="btn btn-primary me-1" onclick="entra();">
<?php echo __("Entra"); ?>
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
