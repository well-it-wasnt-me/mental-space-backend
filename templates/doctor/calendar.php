<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Full calendar start -->
            <section>
                <div class="app-calendar overflow-hidden border">
                    <div class="row g-0">
                        <!-- Sidebar -->
                        <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                            <div class="sidebar-wrapper">
                                <div class="card-body d-flex justify-content-center">
                                    <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal" data-bs-target="#add-new-sidebar">
                                        <span class="align-middle"><?php echo __("Aggiungi Appuntamento"); ?></span>
                                    </button>
                                </div>
                                <div class="card-body pb-0">
                                    <h5 class="section-label mb-1">
                                        <span class="align-middle"><?php echo __("Filtro"); ?></span>
                                    </h5>
                                    <div class="form-check mb-1">
                                        <input type="checkbox" class="form-check-input select-all" id="select-all" checked />
                                        <label class="form-check-label" for="select-all"><?php echo __("Vedi tutto"); ?></label>
                                    </div>
                                    <div class="calendar-events-filter">
                                        <div class="form-check form-check-danger mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="personal" data-value="personal" checked />
                                            <label class="form-check-label" for="personal"><?php echo __("Personale"); ?></label>
                                        </div>
                                        <div class="form-check form-check-primary mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="business" data-value="business" checked />
                                            <label class="form-check-label" for="business"><?php echo __("Lavoro"); ?></label>
                                        </div>
                                        <div class="form-check form-check-warning mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="family" data-value="family" checked />
                                            <label class="form-check-label" for="family"><?php echo __("Famiglia") ?></label>
                                        </div>
                                        <div class="form-check form-check-success mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="holiday" data-value="holiday" checked />
                                            <label class="form-check-label" for="holiday"><?php echo __("Festa"); ?></label>
                                        </div>
                                        <div class="form-check form-check-info">
                                            <input type="checkbox" class="form-check-input input-filter" id="etc" data-value="etc" checked />
                                            <label class="form-check-label" for="etc"><?php echo __("Altro"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <img src="../../../app-assets/images/pages/calendar-illustration.png" alt="Calendar illustration" class="img-fluid" />
                            </div>
                        </div>
                        <!-- /Sidebar -->

                        <!-- Calendar -->
                        <div class="col position-relative">
                            <div class="card shadow-none border-0 mb-0 rounded-0">
                                <div class="card-body pb-0">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /Calendar -->
                        <div class="body-content-overlay"></div>
                    </div>
                </div>
                <!-- Calendar Add/Update/Delete event modal-->
                <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                    <div class="modal-dialog sidebar-lg">
                        <div class="modal-content p-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title"><?php echo __("Aggiungi Appuntamento"); ?></h5>
                            </div>
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <form class="event-form needs-validation" data-ajax="false" novalidate>
                                    <div class="mb-1">
                                        <label for="title" class="form-label"><?php echo __("Titolo") ?></label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Titolo Appuntamento" required />
                                    </div>
                                    <div class="mb-1">
                                        <label for="select-label" class="form-label"><?php echo __("Tipo Appuntamento"); ?></label>
                                        <select class="select2 select-label form-select w-100" id="label" name="label">
                                            <option data-label="primary" value="Business" selected><?php echo __("Lavoro"); ?></option>
                                            <option data-label="danger" value="Personal"><?php echo __("Personale"); ?></option>
                                            <option data-label="warning" value="Family"><?php echo __("Famiglia"); ?></option>
                                            <option data-label="success" value="Holiday"><?php echo __("Festa");?></option>
                                            <option data-label="info" value="ETC"><?php echo __("Altro");?></option>
                                        </select>
                                    </div>
                                    <div class="mb-1 position-relative">
                                        <label for="start-date" class="form-label"><?php echo __("Data Inizio"); ?></label>
                                        <input type="text" class="form-control" id="start-date" name="start-date" placeholder="Data e ora Inizio" />
                                    </div>
                                    <div class="mb-1 position-relative">
                                        <label for="end-date" class="form-label"><?php echo __("Data Fine"); ?></label>
                                        <input type="text" class="form-control" id="end-date" name="end-date" placeholder="Data e ora Fine" />
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input allDay-switch" id="customSwitch3" />
                                            <label class="form-check-label" for="customSwitch3"><?php echo __("Tutto il Giorno"); ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label for="event-url" class="form-label"><?php echo __("URL Evento"); ?></label>
                                        <input type="url" class="form-control" id="event-url" placeholder="https://www.google.com" />
                                    </div>
                                    <div class="mb-1 select2-primary">
                                        <label for="event-guests" class="form-label"><?php echo __("Aggiungi Partecipante"); ?></label>
                                        <select class="select2 select-add-guests form-select w-100" id="event-guests">

                                        </select>
                                    </div>
                                    <div class="mb-1">
                                        <label for="event-location" class="form-label"><?php echo __("Luogo"); ?></label>
                                        <input type="text" class="form-control" id="event-location" placeholder="Metti Indirizzo" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label"><?php echo __("Descrizione"); ?></label>
                                        <textarea name="event-description-editor" id="event-description-editor" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-1 d-flex">
                                        <button type="submit" class="btn btn-primary add-event-btn me-1"><?php echo __("Aggiungi"); ?></button>
                                        <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal"><?php echo __("Cancella"); ?></button>
                                        <button type="submit" class="btn btn-primary update-event-btn d-none me-1"><?php echo __("Aggiorna"); ?></button>
                                        <button class="btn btn-outline-danger btn-delete-event d-none"><?php echo __("Elimina"); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Calendar Add/Update/Delete event modal-->
            </section>
            <!-- Full calendar end -->

        </div>
    </div>
</div>
<!-- END: Content-->