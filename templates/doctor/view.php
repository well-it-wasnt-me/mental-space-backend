<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Account</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/pages/home_doctor">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#"><?php echo __("Dottore"); ?> </a>
                                </li>
                                <li class="breadcrumb-item active"> Account
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills mb-2">
                        <!-- account -->
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="pill" href="#home"
                               aria-expanded="true">
                                <i data-feather="user" class="font-medium-3 me-50"></i>
                                <span class="fw-bold">Account</span>
                            </a>
                        </li>
                        <!-- security -->
                        <li class="nav-item">
                            <a class="nav-link" href="#security" data-bs-toggle="pill" aria-expanded="false">
                                <i data-feather="lock" class="font-medium-3 me-50"></i>
                                <span class="fw-bold"><?php echo __("Sicurezza"); ?></span>
                            </a>
                        </li>
                        <!-- billing and plans -->
                        <li class="nav-item">
                            <a class="nav-link" href="#billing" data-bs-toggle="pill" aria-expanded="false">
                                <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                                <span class="fw-bold"><?php echo __("Abbonamento"); ?></span>
                            </a>
                        </li>
                    </ul>


                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="home" aria-labelledby="home-tab"
                             aria-expanded="true">
                            <!-- profile -->
                            <div class="card">
                                <!--                  <div role="tabpanel" class="tab-pane active" id="home" aria-labelledby="home-tab" aria-expanded="true"> -->
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"><?php echo __("Dettaglio Profilo"); ?></h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <!-- header section -->
                                    <div class="d-flex">
                                        <a href="#" class="me-25">
                                            <img src="<?php echo get_gravatar($email); ?>" id="account-upload-img"
                                                 class="uploadedAvatar rounded me-50" alt="profile image" height="100"
                                                 width="100"/>
                                        </a>
                                        <!-- upload and reset button -->
                                        <div class="d-flex align-items-end mt-75 ms-1">
                                            <div>
                                                <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                                                <input type="file" id="account-upload" hidden accept="image/*"/>
                                                <button type="button" id="account-reset"
                                                        class="btn btn-sm btn-outline-secondary mb-75">Reset
                                                </button>
                                                <p class="mb-0"><?php echo __("File permessi: png, jpg, jpeg."); ?></p>
                                            </div>
                                        </div>
                                        <!--/ upload and reset button -->
                                    </div>
                                    <!--/ header section -->

                                    <!-- form -->
                                    <form class="validate-form mt-2 pt-50" id="doc_data_frm">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountFirstName"><?php echo __("Nome"); ?></label>
                                                <input type="text" class="form-control" id="accountFirstName"
                                                       name="doc_name" placeholder="John"
                                                       value="<?php echo $doc_name; ?>"
                                                       data-msg="Perfavore inserisci il tuo nome"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountLastName"><?php echo __("Cognome"); ?></label>
                                                <input type="text" class="form-control" id="accountLastName"
                                                       name="doc_surname" placeholder="Doe"
                                                       value="<?php echo $doc_surname; ?>"
                                                       data-msg="Perfavore inserisci il tuo cognome"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label" for="accountEmail">Email</label>
                                                <input type="email" class="form-control" id="accountEmail" name="email"
                                                       placeholder="Email" value="<?php echo $email; ?>" disabled/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountOrganization"><?php echo __("Ragione Sociale"); ?></label>
                                                <input type="text" class="form-control" id="accountOrganization"
                                                       name="doc_rag_soc" placeholder="Ragione Sociale"
                                                       value="<?php echo $doc_rag_soc; ?>"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountPhoneNumber"><?php echo __("Cellulare"); ?></label>
                                                <input type="text" class="form-control account-number-mask"
                                                       id="accountPhoneNumber" name="doc_tel" placeholder="Telefono"
                                                       value="<?php echo $doc_tel ?>"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountAddress"><?php echo __("Indirizzo"); ?></label>
                                                <input type="text" class="form-control" id="accountAddress"
                                                       name="doc_address" placeholder="Indirizzo Completo"
                                                       value="<?php echo $doc_address; ?>"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="accountState"><?php echo __("Tariffa Oraria (€)"); ?></label>
                                                <input type="number" class="form-control" id="accountTariffa"
                                                       name="doc_hourlyrate" placeholder="Tariffa Oraria - 80"
                                                       value="<?php echo $doc_hourlyrate; ?>"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="partitaIva"><?php echo __("Partita IVA"); ?></label>
                                                <input type="text" class="form-control account-zip-code" id="partitaIva"
                                                       name="doc_piva" placeholder="01234567890" maxlength="20"
                                                       value="<?php echo $doc_piva; ?>"/>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="paypal"><?php echo __("Account PayPal"); ?></label>
                                                <input type="text" class="form-control account-zip-code" id="paypal"
                                                       name="doc_paypal" placeholder="indirizzo@email.it"
                                                       value="<?php echo $doc_paypal; ?>"/>
                                            </div>

                                            <div class="col-12">
                                                <a onclick="updateAccount()"
                                                   class="btn btn-primary mt-1 me-1"><?php echo __("Salva"); ?></a>
                                                <button type="reset"
                                                        class="btn btn-outline-secondary mt-1"><?php echo __("Annulla"); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ form -->
                                </div>
                            </div>

                            <!-- deactivate account  -->
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"><?php echo __("Eliminazione Account"); ?></h4>
                                </div>
                                <div class="card-body py-2 my-25">
                                    <div class="alert alert-warning">
                                        <h4 class="alert-heading"><?php echo __("Sei sicuro di voler cancellare il tuo account ?"); ?></h4>
                                        <div class="alert-body fw-normal">
                                            <?php echo __("Questa operazione è irreversibile e perderai tutti i tuoi dati"); ?>
                                        </div>
                                    </div>

                                    <form id="formAccountDeactivation" class="validate-form" onsubmit="return false">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                                   id="accountActivation"
                                                   data-msg="Perfavore conferma che vuoi davvero eliminare l'account"/>
                                            <label class="form-check-label font-small-3" for="accountActivation">
                                                <?php echo __("Confermo l'eliminazione del mio account"); ?>
                                            </label>
                                        </div>
                                        <div>
                                            <button type="submit"
                                                    class="btn btn-danger deactivate-account mt-1"><?php echo __("Elimina Account"); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--/ profile -->
                        </div>

                        <div class="tab-pane" id="security" role="tabpanel" aria-labelledby="security"
                             aria-expanded="false">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"><?php echo __("Cambio Password"); ?></h4>
                                </div>
                                <div class="card-body pt-1">
                                    <!-- form -->
                                    <form class="validate-form" id="frm_cambio_pwd">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="account-old-password"><?php echo __("Password Attuale"); ?></label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control"
                                                           id="account-old-password" name="password"
                                                           placeholder="Inserire password attuale"
                                                           data-msg="Perfavore inserisci password attuale"/>
                                                    <div class="input-group-text cursor-pointer">
                                                        <i data-feather="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="account-new-password"><?php echo __("Nuova Password"); ?></label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" id="account-new-password" name="new-password"
                                                           class="form-control" placeholder="Nuova Password"/>
                                                    <div class="input-group-text cursor-pointer">
                                                        <i data-feather="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 mb-1">
                                                <label class="form-label"
                                                       for="account-retype-new-password"><?php echo __("Riscrivi Nuova Password"); ?></label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" class="form-control"
                                                           id="account-retype-new-password" name="confirm-new-password"
                                                           placeholder="Conferma Password"/>
                                                    <div class="input-group-text cursor-pointer"><i
                                                                data-feather="eye"></i></div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p class="fw-bolder"><?php echo __("Requisiti Password:"); ?></p>
                                                <ul class="ps-1 ms-25">
                                                    <li class="mb-50"><?php echo __("Minimo 8 caratteri"); ?></li>
                                                    <li class="mb-50"><?php echo __("Maiuscole e Minuscole"); ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-12">
                                                <a onclick="passwordUpdate();"
                                                   class="btn btn-primary me-1 mt-1"><?php echo __("Salva"); ?></a>
                                                <button type="reset"
                                                        class="btn btn-outline-secondary mt-1"><?php echo __("Annulla"); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ form -->
                                </div>
                            </div>

                            <!-- create API key -->
                            <!-- <div class="card">
                                 <div class="card-header pb-0">
                                     <h4 class="card-title">PayPal API </h4>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-5 order-md-0 order-1">
                                         <div class="card-body">

                                             <form id="createApiForm" class="validate-form" onsubmit="return false">
                                                 <div class="mb-2">
                                                     <label for="PayPalApiKey" class="form-label">PayPal Client ID</label>
                                                     <input class="form-control" type="text" name="PayPalapiKey" placeholder="AbMch521Edh50hJ0BM7ECZ0XAZV25t9-YUhr0s3ssQXeTWoYwacHXoRW8E_Pwl_JmBnxas_1Le-UTkM9" id="PayPalApiKey" data-msg="Please enter API key name" />
                                                 </div>

                                                 <button type="submit" class="btn btn-primary w-100">Salva</button>
                                             </form><br>
                                             <a href="https://developer.paypal.com/dashboard/" target="_blank" class="btn btn-primary w-100">Recuperare Client ID</a>
                                         </div>
                                     </div>
                                     <div class="col-md-7 order-md-1 order-0">
                                         <div class="text-center">
                                             <img class="img-fluid text-center" src="../../../app-assets/images/illustration/pricing-Illustration.svg" alt="illustration" width="310" />
                                         </div>
                                     </div>
                                 </div>
                             </div>-->
                            <!-- / create API key -->

                            <!-- recent device -->
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Accessi Recenti</h4>
                                </div>
                                <div class="card-body my-2 py-25">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-nowrap text-center" id="tbl_accessi">
                                            <thead>
                                            <tr>
                                                <th class="text-start">BROWSER</th>
                                                <th class="text-start"><?php echo __("INDIRIZZO IP"); ?></th>
                                                <th><?php echo __("DISPOSITIVO"); ?></th>
                                                <th><?php echo __("LOCATION"); ?></th>
                                                <th><?php echo __("DATA ATTIVITA'"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- / recent device -->
                        </div>

                        <div class="tab-pane" id="billing" role="tabpanel" aria-labelledby="billing"
                             aria-expanded="false">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title"><?php echo __("Piano Corrente"); ?></h4>
                                </div>
                                <div class="card-body my-2 py-25">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-warning mb-2" role="alert">
                                                <h6 class="alert-heading"><?php echo __("Attenzione!"); ?></h6>
                                                <div class="alert-body fw-normal">
                                                    <?php echo __('Da oggi per gestire pagamenti ed abbonamenti abbiamo messo a disposizione
                                               portale Stripe, clicca 
                                               <a target="_blank" href="https://billing.stripe.com/p/login/00g01A2xyfWMdxe9AA" class="btn btn-sm btn-primary">QUI</a>'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <!--<button class="btn btn-outline-danger cancel-subscription mt-1">Elimina Account</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / payment methods -->


                            <!-- billing history table -->
                            <!-- / billing history table -->

                            <!--/ billing and plans -->
                        </div>
                    </div>

                    <!--/ edit card modal  -->
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>