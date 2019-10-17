<!-- ========== Left Sidebar Start ========== -->
           <div class="left-side-menu" style="background: linear-gradient(135deg,#0F2027 0,#2C5364 60%) !important;">

               <div class="slimscroll-menu">

                   <!-- LOGO -->
                   <a href="#" class="logo text-center">
                       <!-- <span class="logo-lg">
                           <img src="<?php echo base_url();?>assets/global/logo.png" alt="" height="40">
                       </span> -->

                       <!-- We should use a small logo for this image tag -->
                    <!--    <span class="logo-sm">
                           <img src="<?php echo base_url();?>assets/global/logo.png" alt="" height="40">
                       </span> -->
                   </a>

                   <!--- Sidemenu -->
                   <ul class="metismenu side-nav">
                       <li class="side-nav-item <?php if ($page_name == 'dashboard')echo 'active';?>">
                           <a href="<?php echo base_url();?>admin/dashboard" class="side-nav-link <?php if ($page_name == 'dashboard')echo 'active';?>">
                               <i class="dripicons-meter"></i>
                               <span> Dashboard </span>
                           </a>
                       </li>
                          <li
                       <?php
                       $is_active = '';
                       if ( $page_name == 'chashi_category'    ||
                            $page_name == 'chashi_products'    ||
                            $page_name == 'chashi_vendors') $is_active = 'active'; ?>
                        class="side-nav-item <?php echo $is_active; ?>">
                           <a href="javascript: void(0);" class="side-nav-link <?php echo $is_active; ?>">
                               <i class="dripicons-view-apps"></i>
                               <span>Chashi </span>
                               <span class="menu-arrow"></span>
                           </a>
                           <ul class="side-nav-second-level" aria-expanded="false">
                               <li class = "<?php if($page_name == 'chashi_category') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/chashi_category" class = "">Category</a>
                               </li>
                                   <li class = "<?php if($page_name == 'chashi_products') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/chashi_product_list" class = "">products</a>
                               </li>

                              <li class = "<?php if($page_name == 'chashi_vendors') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/chashi_vendors" class = "">Vendors</a>
                               </li>
                              



                              
                           </ul>
                       </li>

                   <li
                       <?php
                       $is_active = '';
                       if ( $page_name == 'grocery_vendors'    ||
                            $page_name == 'chashi_product'    ||
                            $page_name == 'chashi_vendors') $is_active = 'active'; ?>
                        class="side-nav-item <?php echo $is_active; ?>">
                           <a href="javascript: void(0);" class="side-nav-link <?php echo $is_active; ?>">
                               <i class="dripicons-view-apps"></i>
                               <span>Grocery </span>
                               <span class="menu-arrow"></span>
                           </a>
                           <ul class="side-nav-second-level" aria-expanded="false">
                               <li class = "<?php if($page_name == 'grocery_vendors') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/grocery_vendors" class = "">Vendors</a>
                               </li>

                              <!-- <li class = "<?php if($page_name == 'chashi_vendors') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/chashi_vendors" class = "">Vendors</a>
                               </li> -->

                              
                           </ul>
                       </li>
                        <li
                       <?php
                       $is_active = '';
                       if ( $page_name == 'haat_vendors'    ||
                            $page_name == 'chashi_product'    ||
                            $page_name == 'chashi_vendors') $is_active = 'active'; ?>
                        class="side-nav-item <?php echo $is_active; ?>">
                           <a href="javascript: void(0);" class="side-nav-link <?php echo $is_active; ?>">
                               <i class="dripicons-view-apps"></i>
                               <span>Haat </span>
                               <span class="menu-arrow"></span>
                           </a>
                           <ul class="side-nav-second-level" aria-expanded="false">
                               <li class = "<?php if($page_name == 'haat_vendors') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/haat_vendors" class = "">Vendors</a>
                               </li>

                              <!-- <li class = "<?php if($page_name == 'chashi_vendors') echo 'active'; ?>">
                                   <a href="<?php echo base_url();?>admin/chashi_vendors" class = "">Vendors</a>
                               </li> -->

                              
                           </ul>
                       </li>
 
                       <li class="side-nav-item <?php if($page_name == 'account')echo 'active';?>">
                           <a href="<?php echo base_url();?>admin/account" class="side-nav-link <?php if($page_name == 'account')echo 'active';?>">
                               <i class="dripicons-meter"></i>
                               <span> Account</span>
                           </a>
                       </li>
                   </ul>
                   <div class="clearfix"></div>
               </div>
               <!-- Sidebar -left -->
           </div>
           <!-- Left Sidebar End -->
