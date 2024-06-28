<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar hidebar" style="overflow:auto;">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li>
                    <a class="" href="<?= base_url("utama"); ?>" aria-expanded="false">
                        <i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span>
                    </a>

                </li>
                <?php 
                // dd(session()->get("position_id")[0][0]);
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['1']['act_read']) 
                        && session()->get("halaman")['1']['act_read'] == "1"
                    )
                ) { ?>
                <li class="nav-label">Master</li>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['28']['act_read']) 
                        && session()->get("halaman")['28']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("midentity"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Identitas</span></a>
                </li>
                <?php }?>               
                
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['2']['act_read']) 
                        && session()->get("halaman")['2']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="has-arrow  " href="#" aria-expanded="false" data-toggle="collapse" data-target="#demo"><i class="fa fa-user"></i><span class="hide-menu">Manajemen User <span class="label label-rouded label-warning pull-right">2</span></span></a>
                    <ul aria-expanded="false" id="demo" class="collapse">
                        <?php 
                        if (
                            (
                                isset(session()->get("position_id")[0][0]) 
                                && (
                                    session()->get("position_id") == "1" 
                                    || session()->get("position_id") == "2"
                                )
                            ) ||
                            (
                                isset(session()->get("halaman")['3']['act_read']) 
                                && session()->get("halaman")['3']['act_read'] == "1"
                            )
                        ) { ?>
                        <li><a href="<?= base_url("mposition"); ?>"><i class="fa fa-caret-right"></i> &nbsp;Posisi</a></li>
                        <?php }?>
                        <?php 
                        if (
                            (
                                isset(session()->get("position_id")[0][0]) 
                                && (
                                    session()->get("position_id") == "1" 
                                    || session()->get("position_id") == "2"
                                )
                            ) ||
                            (
                                isset(session()->get("halaman")['5']['act_read']) 
                                && session()->get("halaman")['5']['act_read'] == "1"
                            )
                        ) { ?>
                        <li><a href="<?= base_url("muser"); ?>"><i class="fa fa-caret-right"></i> &nbsp;User</a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['66']['act_read']) 
                        && session()->get("halaman")['66']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mapk"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">APK</span></a>
                </li>
                <?php }?>  
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['49']['act_read']) 
                        && session()->get("halaman")['49']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mestate"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Estate</span></a>
                </li>
                <?php }?>   
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['50']['act_read']) 
                        && session()->get("halaman")['50']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mdivisi"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Divisi</span></a>
                </li>
                <?php }?>  
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['53']['act_read']) 
                        && session()->get("halaman")['53']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mseksi"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Seksi</span></a>
                </li>
                <?php }?>     
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['51']['act_read']) 
                        && session()->get("halaman")['51']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mblok"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">Blok</span></a>
                </li>
                <?php }?>   
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['52']['act_read']) 
                        && session()->get("halaman")['52']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mtph"); ?>" aria-expanded="false"><i class="fa fa-building"></i><span class="hide-menu">TPH</span></a>
                </li>
                <?php }?>   
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['54']['act_read']) 
                        && session()->get("halaman")['54']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mplacement"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Placement</span></a>
                </li>
                <?php }?>    
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['56']['act_read']) 
                        && session()->get("halaman")['56']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mtphnumber"); ?>" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">TPH Card</span></a>
                </li>
                <?php }?>     
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['68']['act_read']) 
                        && session()->get("halaman")['68']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mwtnumber"); ?>" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">WT Card</span></a>
                </li>
                <?php }?>    
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['57']['act_read']) 
                        && session()->get("halaman")['57']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("msptbsnumber"); ?>" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">SPTBS Card</span></a>
                </li>
                <?php }?>    
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['64']['act_read']) 
                        && session()->get("halaman")['64']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mquarrynumber"); ?>" aria-expanded="false"><i class="fa fa-id-card"></i><span class="hide-menu">QUARRY Card</span></a>
                </li>
                <?php }?>   
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['58']['act_read']) 
                        && session()->get("halaman")['58']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mgradingtype"); ?>" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">Tipe Grading</span></a>
                </li>
                <?php }?>   
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['61']['act_read']) 
                        && session()->get("halaman")['61']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mwt"); ?>" aria-expanded="false"><i class="fa fa-truck"></i><span class="hide-menu">Vehicle</span></a>
                </li>
                <?php }?>    
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['67']['act_read']) 
                        && session()->get("halaman")['67']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mlr"); ?>" aria-expanded="false"><i class="fa fa-shopping-cart"></i><span class="hide-menu">Loading Ramp</span></a>
                </li>
                <?php }?>  
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['62']['act_read']) 
                        && session()->get("halaman")['62']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("mquarrytype"); ?>" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">Quarry Type</span></a>
                </li>
                <?php }?>    
                

                
               

                

                


                <?php }?>

               


                <!-- //Transaction// -->
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['9']['act_read']) 
                        && session()->get("halaman")['9']['act_read'] == "1"
                    )
                ) { ?>
                <li class="nav-label">Transaksi</li>

                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['47']['act_read']) 
                        && session()->get("halaman")['47']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rkh"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">RKH</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['55']['act_read']) 
                        && session()->get("halaman")['55']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("synchron"); ?>" aria-expanded="false"><i class="fa fa-balance-scale"></i><span class="hide-menu">Timbangan</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['59']['act_read']) 
                        && session()->get("halaman")['59']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("grading"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Grading</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['60']['act_read']) 
                        && session()->get("halaman")['60']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("absen"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Absensi</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['63']['act_read']) 
                        && session()->get("halaman")['63']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("quarry"); ?>" aria-expanded="false"><i class="fa fa-truck"></i><span class="hide-menu">Quarry</span></a>
                </li>
                <?php }?>


                <?php }?>











                <!-- //Report// -->
                <?php 
                
                // dd(session()->get("halaman")) ;
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['14']['act_read']) 
                        && session()->get("halaman")['14']['act_read'] == "1"
                    )
                ) { ?>
                <li class="nav-label">Laporan</li>

                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['47']['act_read']) 
                        && session()->get("halaman")['47']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rkh?report=ok"); ?>" aria-expanded="false"><i class="fa fa-hand-rock-o "></i><span class="hide-menu">RKH Report</span></a>
                </li>
                <?php }?>

                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['84']['act_read']) 
                        && session()->get("halaman")['84']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rpanen"); ?>" aria-expanded="false"><i class="fa fa-hand-rock-o "></i><span class="hide-menu">Data Panen</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['75']['act_read']) 
                        && session()->get("halaman")['75']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rcpo"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">TBS ke CPO Mill</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['85']['act_read']) 
                        && session()->get("halaman")['85']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rrestand"); ?>" aria-expanded="false"><i class="fa fa-hand-rock-o "></i><span class="hide-menu">Data Restand</span></a>
                </li>
                <?php }?>


                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['65']['act_read']) 
                        && session()->get("halaman")['65']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("quarry?report=OK"); ?>" aria-expanded="false"><i class="fa fa-truck"></i><span class="hide-menu">Quarry Report</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['69']['act_read']) 
                        && session()->get("halaman")['69']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rpanenfinance"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Rincian SPTBS</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['71']['act_read']) 
                        && session()->get("halaman")['71']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rgrading"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Data Grading</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['72']['act_read']) 
                        && session()->get("halaman")['72']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rpruning"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Inspeksi Panen</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['73']['act_read']) 
                        && session()->get("halaman")['73']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rpruningd"); ?>" aria-expanded="false"><i class="fa fa-pagelines"></i><span class="hide-menu">Inspeksi Panen Detail</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['74']['act_read']) 
                        && session()->get("halaman")['74']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rabsend"); ?>" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Rangkuman Absensi</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['76']['act_read']) 
                        && session()->get("halaman")['76']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rhkp"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Hasil Kerja Pemanen</span></a>
                </li>
                <?php }?>

                
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['77']['act_read']) 
                        && session()->get("halaman")['77']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rperiode"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Periode</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['78']['act_read']) 
                        && session()->get("halaman")['78']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rrekap"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Rekap</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['79']['act_read']) 
                        && session()->get("halaman")['79']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rrencana"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Rencana & Realisasi</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['80']['act_read']) 
                        && session()->get("halaman")['80']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rrekapdu"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Rekap DU</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['81']['act_read']) 
                        && session()->get("halaman")['81']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rtanggal"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Tanggal Pengiriman TBS</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['82']['act_read']) 
                        && session()->get("halaman")['82']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rlangsir"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Blok Langsir</span></a>
                </li>
                <?php }?>
                <?php 
                if (
                    (
                        isset(session()->get("position_id")[0][0]) 
                        && (
                            session()->get("position_id") == "1" 
                            || session()->get("position_id") == "2"
                        )
                    ) ||
                    (
                        isset(session()->get("halaman")['82']['act_read']) 
                        && session()->get("halaman")['82']['act_read'] == "1"
                    )
                ) { ?>
                <li> 
                    <a class="  " href="<?= base_url("rschedule"); ?>" aria-expanded="false"><i class="fa fa-tree"></i><span class="hide-menu">Schedule Panen</span></a>
                </li>
                <?php }?>


                

                <?php }?>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>