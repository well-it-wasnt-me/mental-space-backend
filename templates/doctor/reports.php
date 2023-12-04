<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Reports</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/pages/home_doctor">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Reports</a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo __("New");?>
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
                                        <span class="bs-stepper-title"><?php echo __("Base Selection"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("Select the recipient(s)"); ?></span>
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
                                        <span class="bs-stepper-title"><?php echo __("Select Data"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("What you wish to extract ?"); ?></span>
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
                                        <span class="bs-stepper-title"><?php echo __("Grouping"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("How do you wish to group your data ?"); ?></span>
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
                                        <span class="bs-stepper-title"><?php echo __("End"); ?></span>
                                        <span class="bs-stepper-subtitle"><?php echo __("See the results"); ?></span>
                                    </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Base Selection"); ?></h5>
                                <small class="text-muted"><?php echo __("From where to start ?"); ?></small>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="mb-1 col-md-12">
                                        <label class="form-label" for="username"><?php echo __("Patients (leave empty to select them all)"); ?></label>
                                        <select name="assistiti[]" id="assistiti" class="form-control" multiple>
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary btn-prev" disabled>
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Back");?></span>
                                </button>
                                <button class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Next"); ?></span>
                                    <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                                </button>
                            </div>
                        </div>
                        <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("Data Selection"); ?></h5>
                                <small><?php echo __("On what you wish to work ?"); ?></small>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-12">
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="diario" value="diario">
                                        <label class="form-check-label" for="diario"><?php echo __("Diary Analysis"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="diagnosi" value="diagnosi">
                                        <label class="form-check-label" for="diagnosi"><?php echo __("Diagnosis"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="emozioni" value="emozioni">
                                        <label class="form-check-label" for="emozioni"><?php echo __("Emotions"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="farmaci" value="farmaci">
                                        <label class="form-check-label" for="farmaci"><?php echo __("Drugs"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="mood_trackings" value="mood_trackings">
                                        <label class="form-check-label" for="mood_trackings"><?php echo __("Humor"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="passi" value="passi">
                                        <label class="form-check-label" for="passi"><?php echo __("Steps"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input tables-check-input" id="phq9" value="phq9">
                                        <label class="form-check-label" for="phq9"><?php echo __("Depression"); ?></label>
                                    </div></div><hr>
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
                                <h5 class="mb-0"><?php echo __("Grouping"); ?></h5>
                                <small><?php echo __("What you wish to group"); ?></small>
                            </div>
                            <form>
                                <div class="col-12">
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input raggr-check-input" id="eta" value="eta">
                                        <label class="form-check-label" for="eta"><?php echo __("Age");?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input raggr-check-input" id="ass" value="ass">
                                        <label class="form-check-label" for="ass"><?php echo __("Patient"); ?></label>
                                    </div><br>
                                    <div class="form-check form-check-primary">
                                        <input type="checkbox" class="form-check-input raggr-check-input" id="diag" value="diag">
                                        <label class="form-check-label" for="diag"><?php echo __("Diagnosis"); ?></label>
                                    </div><br>
                                    </div><hr>
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
                        <div id="social-links" class="content" role="tabpanel" aria-labelledby="social-links-trigger">
                            <div class="content-header">
                                <h5 class="mb-0"><?php echo __("End"); ?></h5>
                                <small><?php echo __("Generete the Report"); ?></small>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-12">
<?php echo __("Press the bnutton \"CREATE\" in order to have your report in PDF"); ?>
                                    </div>
                                    <div class="col-12" id="report_result">

                                    </div>
                                </div>
                            </form><br><hr><br>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev">
                                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none"><?php echo __("Back"); ?></span>
                                </button>
                                <button class="btn btn-success btn-submit"><?php echo __("CREATE!"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Horizontal Wizard -->

        </div>
    </div>
</div>
<!-- END: Content-->