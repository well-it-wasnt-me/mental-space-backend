<!-- BEGIN: Content-->
<div class="app-content content chat-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-area-wrapper container-xxl p-0">
        <div class="sidebar-left">
            <div class="sidebar">
                <!-- Admin user profile area -->
                <div class="chat-profile-sidebar">
                    <header class="chat-profile-header">
                            <span class="close-icon">
                                <i data-feather="x"></i>
                            </span>
                        <!-- User Information -->
                        <div class="header-profile-sidebar">
                            <div class="avatar box-shadow-1 avatar-xl avatar-border">
                                <img src="<?php echo get_gravatar($email);?>" alt="user_avatar" />
                                <span class="avatar-status-online avatar-status-xl"></span>
                            </div>
                            <h4 class="chat-user-name"><?php echo $doc_name . " " . $doc_surname;?></h4>
                            <span class="user-post">Doctor</span>
                        </div>
                        <!--/ User Information -->
                    </header>
                </div>
                <!--/ Admin user profile area -->

                <!-- Chat Sidebar area -->
                <div class="sidebar-content">
                        <span class="sidebar-close-icon">
                            <i data-feather="x"></i>
                        </span>
                    <!-- Sidebar header start -->
                    <div class="chat-fixed-search">
                        <div class="d-flex align-items-center w-100">
                            <div class="sidebar-profile-toggle">
                                <div class="avatar avatar-border">
                                    <img src="<?php echo get_gravatar($email);?>" alt="user_avatar" height="42" width="42" />
                                    <span class="avatar-status-online"></span>
                                </div>
                            </div>
                            <div class="input-group input-group-merge ms-1 w-100">
                                <span class="input-group-text round"><i data-feather="search" class="text-muted"></i></span>
                                <input type="text" class="form-control round" id="chat-search" placeholder="Search or send messages" aria-label="Search..." aria-describedby="chat-search" />
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar header end -->

                    <!-- Sidebar Users start -->
                    <div id="users-list" class="chat-user-list-wrapper list-group">
                        <h4 class="chat-list-title">Messages</h4>
                        <ul class="chat-users-list contact-list media-list" id="elenco_contatti">
                            <li class="no-results">
                                <h6 class="mb-0">Found nothing to show</h6>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar Users end -->
                </div>
                <!--/ Chat Sidebar area -->

            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="body-content-overlay"></div>
                    <!-- Main chat area -->
                    <section class="chat-app-window">
                        <!-- To load Conversation -->
                        <div class="start-chat-area">
                            <div class="mb-1 start-chat-icon">
                                <i data-feather="message-square"></i>
                            </div>
                            <h4 class="sidebar-toggle start-chat-text">Select a contact</h4>
                            <h3 class="sidebar-toggle start-chat-text msg-loader">Loading...</h3>
                        </div>
                        <!--/ To load Conversation -->

                        <!-- Active Chat -->
                        <div class="active-chat d-none">
                            <!-- Chat Header -->
                            <div class="chat-navbar">
                                <header class="chat-header">
                                    <div class="d-flex align-items-center">
                                        <div class="sidebar-toggle d-block d-lg-none me-1">
                                            <i data-feather="menu" class="font-medium-5"></i>
                                        </div>
                                        <div class="avatar avatar-border user-profile-toggle m-0 me-1">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36" />
                                            <span class="avatar-status-busy"></span>
                                        </div>
                                        <h6 class="mb-0">Kristopher Candy</h6>
                                    </div>
                                </header>
                            </div>
                            <!--/ Chat Header -->

                            <!-- User Chat messages -->
                            <div class="user-chats">
                                <div class="chats">
                                    <div class="chat">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>How can we help? We're here for you! 😄</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>Hey John, I am looking for the best admin template.</p>
                                                <p>Could you please help me to find it out? 🤔</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>It should be Bootstrap 4 compatible.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Yesterday</div>
                                    </div>
                                    <div class="chat">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>Absolutely!</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>Vuexy admin is the responsive bootstrap 4 admin template.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>Looks clean and fresh UI. 😃</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>It's perfect for my next project.</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>How can I purchase it?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>Thanks, from ThemeForest.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat chat-left">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>I will purchase it for sure. 👍</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>Thanks.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat">
                                        <div class="chat-avatar">
                                                <span class="avatar box-shadow-1 cursor-pointer">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="36" width="36" />
                                                </span>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-content">
                                                <p>Great, Feel free to get in touch on</p>
                                            </div>
                                            <div class="chat-content">
                                                <p>https://pixinvent.ticksy.com/</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- User Chat messages -->

                            <!-- Submit Chat form -->
                            <form class="chat-app-form" action="javascript:void(0);" onsubmit="enterChat();">
                                <div class="input-group input-group-merge me-1 form-send-message">
                                    <input type="text" class="form-control message" placeholder="Scrivi il tuo messaggio qui" />
                                </div>
                                <button type="button" class="btn btn-primary send" onclick="enterChat();">
                                    <i data-feather="send" class="d-lg-none"></i>
                                    <span class="d-none d-lg-block">Invia</span>
                                </button>
                            </form>
                            <!--/ Submit Chat form -->
                        </div>
                        <!--/ Active Chat -->
                    </section>
                    <!--/ Main chat area -->

                    <!-- User Chat profile right area -->
                    <div class="user-profile-sidebar">
                        <header class="user-profile-header">
                                <span class="close-icon">
                                    <i data-feather="x"></i>
                                </span>
                            <!-- User Profile image with name -->
                            <div class="header-profile-sidebar">
                                <div class="avatar box-shadow-1 avatar-border avatar-xl">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="user_avatar" height="70" width="70" />
                                    <span class="avatar-status-busy avatar-status-lg"></span>
                                </div>
                                <h4 class="chat-user-name">Kristopher Candy</h4>
                                <span class="user-post">UI/UX Designer 👩🏻‍💻</span>
                            </div>
                            <!--/ User Profile image with name -->
                        </header>
                        <div class="user-profile-sidebar-area">
                            <!-- About User -->
                            <h6 class="section-label mb-1">About</h6>
                            <p>Toffee caramels jelly-o tart gummi bears cake I love ice cream lollipop.</p>
                            <!-- About User -->
                            <!-- User's personal information -->
                            <div class="personal-info">
                                <h6 class="section-label mb-1 mt-3">Personal Information</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-1">
                                        <i data-feather="mail" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">kristycandy@email.com</span>
                                    </li>
                                    <li class="mb-1">
                                        <i data-feather="phone-call" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">+1(123) 456 - 7890</span>
                                    </li>
                                    <li>
                                        <i data-feather="clock" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Mon - Fri 10AM - 8PM</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/ User's personal information -->

                            <!-- User's Links -->
                            <div class="more-options">
                                <h6 class="section-label mb-1 mt-3">Options</h6>
                                <ul class="list-unstyled">
                                    <li class="cursor-pointer mb-1">
                                        <i data-feather="tag" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Add Tag</span>
                                    </li>
                                    <li class="cursor-pointer mb-1">
                                        <i data-feather="star" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Important Contact</span>
                                    </li>
                                    <li class="cursor-pointer mb-1">
                                        <i data-feather="image" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Shared Media</span>
                                    </li>
                                    <li class="cursor-pointer mb-1">
                                        <i data-feather="trash" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Delete Contact</span>
                                    </li>
                                    <li class="cursor-pointer">
                                        <i data-feather="slash" class="font-medium-2 me-50"></i>
                                        <span class="align-middle">Block Contact</span>
                                    </li>
                                </ul>
                            </div>
                            <!--/ User's Links -->
                        </div>
                    </div>
                    <!--/ User Chat profile right area -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>