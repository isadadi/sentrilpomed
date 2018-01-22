              <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Laporan</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->
                      <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                      <li>

                        </a>  
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
    
              <div class="x_content">              
                  
                    <?php foreach($file as $f){ 
                        $tanggal = $f['tanggal_kegiatan'];
                        $tgl = explode('-', $tanggal);
                      ?>
                      <div>
                          <a href="#" onclick="ke_file('<?=base_url('superuser/home/file_laporan/').$tanggal?>')"><?=$tgl[2].'-'.$tgl[1].'-'.$tgl[0]?></a>
                          <hr>
                      </div>
                    <?php } ?>
                    
                    <?php if(isset($links)){ ?>
                      <div>
                        <?=$links?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


