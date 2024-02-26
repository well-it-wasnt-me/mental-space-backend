<?php
/*
 * Mental Space Project - Creative Commons License
 */
?>

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0"><?php echo __('Nuovo Paziente');?></h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/pages/home_doctor">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="/pages/patients/list"><?php echo __("Patients"); ?></a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo __("New"); ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Horizontal Wizard -->
            <section class="horizontal-wizard">
                <div class="bs-stepper horizontal-wizard-example">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">1</span>
                                <span class="bs-stepper-label">
                                        <span class="bs-stepper-title"><?php echo __("Basic Data"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("Basic Informations"); ?></span>
                                    </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#personal-info" role="tab" id="personal-info-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">2</span>
                                <span class="bs-stepper-label">
                                        <span class="bs-stepper-title"><?php echo __("Clinical Datas"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("Anything that might be relevant ?"); ?></span>
                                    </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#address-step" role="tab" id="address-step-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">3</span>
                                <span class="bs-stepper-label">
                                        <span class="bs-stepper-title"><?php echo __("Relation"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("What's your first impression ?"); ?></span>
                                    </span>
                            </button>
                        </div>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#social-links" role="tab" id="social-links-trigger">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-box">4</span>
                                <span class="bs-stepper-label">
                                        <span class="bs-stepper-title"><?php echo __("Mobile App"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("Invite to use the App"); ?></span>
                                    </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Basic Datas"); ?></h5>
                                <small class="text-muted"><?php echo __("Everything is important"); ?></small>
                            </div>
                            <form id="frm_add_paz">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label" for="surname"><?php echo __('Surname');?></label>
                                                <input type="text" name="surname" id="surname" class="form-control" placeholder="Rossi" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="name"><?php echo __('Name');?></label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Giuseppe" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="cf"><?php echo __('SSN');?></label>
                                                <input type="text" name="cf" id="cf" class="form-control" placeholder="RSSGPP80A01F839A" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="dob"><?php echo __('Date of Birth');?></label>
                                                <input type="date" name="dob" id="dob" class="form-control" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="telefono"><?php echo __('Mobile');?></label>
                                                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="333..." />
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="email"><?php echo __('E-Mail');?></label>
                                                <input type="text" name="email" id="email" class="form-control" placeholder="nome@mail.com" />
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label" for="address"><?php echo __('Full Address');?></label>
                                                <input type="text" class="form-control event_form_input" id="address" name="address" placeholder="Indirizzo Completo" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted"><?php echo __('Emergency Contact');?>.</small>
                                        <div class="col-md-6">
                                            <label class="form-label" for="em_nome"><?php echo __('Name and Surname');?></label>
                                            <input type="text" name="em_nome" id="em_nome" class="form-control" placeholder="Rossi Simona" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="em_telefono"><?php echo __('Mobile');?></label>
                                            <input type="text" name="em_telefono" id="em_telefono" class="form-control" placeholder="333..." />
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev" disabled>
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("back"); ?></span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Next"); ?></span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Clinical Datas"); ?></h5>
                                <small><?php echo __("Anything relevant ?"); ?></small>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="mb-1 col-md-4">
                                        <label class="form-label" for="height"><?php echo __('Height (cm)');?></label>
                                        <input type="number" name="height" id="height" class="form-control" placeholder="180" />
                                    </div>
                                    <div class="mb-1 col-md-4">
                                        <label class="form-label" for="weight"><?php echo __('Weight (kg)');?></label>
                                        <input type="number" name="weight" id="weight" class="form-control" placeholder="90" />
                                    </div>
                                    <div class="mb-1 col-md-4">
                                        <label class="form-label" for="dsm_id"><?php echo __('Diagnosis (as per DSM-5)');?></label>
                                        <select class="select2 form-select" name="dsm_id[]" id="dsm_id" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-1 col-md-9">
                                        <label class="form-label" for="curr_pharms"><?php echo __("Actual pharmacological Treatment"); ?></label>
                                        <select class="select2 w-100 js-data-example-ajax" id="curr_pharms" name="curr_pharms[]" multiple>
                                        </select>
                                    </div>
                                    <div class="mb-1 col-md-3">
                                        <label class="form-label"><?php echo __("Drug not in the list"); ?></label>
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modals-slide-in"><?php echo __("Add new Drug"); ?></a>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Back"); ?></span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Next"); ?></span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="address-step" class="content" role="tabpanel" aria-labelledby="address-step-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Relation");?></h5>
                                <small><?php echo __("Your Impressions"); ?></small>
                            </div>
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
                                                                    <h1 class="ql-align-center"><?php echo __("Relation on Patient"); ?></h1>
                                                                    <p class="card-text"><br /></p>
                                                                    <p class="card-text">
<?php echo __("Scrivere qui"); ?>
                                                                    </p>
                                                                    <p class="card-text"><br /></p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Back");?></span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Next"); ?></span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="social-links" class="content" role="tabpanel" aria-labelledby="social-links-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Mobile App"); ?></h5>
                                <small><?php echo __("Invite"); ?></small>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="mb-1 col-md-6">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="checked" checked/>
                                        <label class="form-check-label" for="inlineCheckbox1"><?php echo __("Invite to download the App"); ?></label>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Back"); ?></span>
                                </button>
                                <button class="btn btn-success btn-submit"><?php echo __("Insert"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Horizontal Wizard -->

        </div>
    </div>
</div>





<div class="modal modal-slide-in fade" id="modals-slide-in">
    <div class="modal-dialog sidebar-sm">
        <form id="add-new-drug" class="add-new-record modal-content pt-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo __("Nuovo Farmaco"); ?></h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-fullname"><?php echo __("Principio Attivo"); ?></label>
                    <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname" placeholder="Molecola" aria-label="John Doe" />
                </div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-post"><?php echo __("Descrizione Gruppo"); ?></label>
                    <input type="text" id="basic-icon-default-post" class="form-control dt-post" placeholder="ABACAVIR 300MG 60 UNITA' USO ORALE" aria-label="ABACAVIR 300MG 60 UNITA' USO ORALE" />
                </div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-email"><?php echo __("Denominazione"); ?> </label>
                    <input type="text" id="basic-icon-default-email" class="form-control dt-email" placeholder="ZIAGEN*60 cpr riv 300 mg" aria-label="ZIAGEN*60 cpr riv 300 mg" />
                </div>
                <div class="mb-1">
                    <label class="form-label" for="basic-icon-default-date"><?php echo __("Prezzo"); ?></label>
                    <input type="text" class="form-control dt-date" id="basic-icon-default-date" placeholder="17.20" aria-label="17.20" />
                </div>
                <button type="button" class="btn btn-primary data-submit me-1"><?php echo __("Aggiungi"); ?></button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo __("Cancella"); ?></button>
            </div>
        </form>
    </div>
</div>