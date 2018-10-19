
<div class="right_col" role="main">
          <section class="row">
                  <div class="col-md-6 col-sm-4 col-xs-4">
                      <h3>รายงานบัญชีรายรับ</h3>
                  </div>
                  <div class="col-md-6 col-sm-8 col-xs-8 text-right" style="margin-top: 7px;">
                      <div class="btn-group">
                      </div>
                  </div>
          </section>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" style="top: 10px;">
                  <div class="col-xs-12 ">
                      <h5 class="inline text-right">ข้อมูล ณ วันที่
                        <?php echo $this->mydate->date_eng2thai(date('Y-m-d'), 543, 'S') ?>
                      
                      </h5> 
                  </div>
                  <div class="container-fluid">
                      <div class="row-container">
                        <div class="col-sm-6">
                          <div class="col-md-12 text-right" style="margin-bottom: 7px; padding-right: 0;">
                              <div class="btn-group">
                                  <button onclick="window.open('<?php echo base_url('export_report/report_rec_sum?type=pdf');?>');" type="button" class="btn btn-success" title="ส่งออก pdf"> <i class="fa fa-file-pdf-o"> </i> ส่งออก pdf
                                  </button>
                                  <button onclick="window.open('<?php echo base_url('export_report/report_rec_sum');?>');" type="button" class="btn btn-success" title="ส่งออก excel"> <i class="fa fa-file-excel-o"> </i> ส่งออก excel
                                  </button>
                              </div>
                          </div>
                           <?php foreach ($getrec[0] as $key => $title) {
                            foreach ($getrec[$title->tax_id] as $key => $title2) {
                              @$sum[$title->tax_id]->tax_estimate += $title2->tax_estimate;
                              @$sum[$title->tax_id]->receive_amount += $title2->receive_amount;
                            } ?>
                           <?php 
                        } ?>
                           <table class="table table-bordered table-striped ">
                              <thead>
                                <tr>
                                    <th style="width:40%">รายการ</th>
                                    <th style="width:20%">ประมานการรายรับ</th>
                                    <th style="width:20%">รายรับจริง</th>
                                    <th style="width:20%">+สูง -ต่ำ</th>
                                </tr>
                              </thead>
                              <tbody>
                           <?php $labels_chart = $datasets1 = $datasets2 = '';
                          $sum1 = $sum2 = 0;
                          foreach ($getrec[0] as $key => $title) {
                           
                            $diff = $sum[$title->tax_id]->receive_amount - $sum[$title->tax_id]->tax_estimate;
                            $color = '';
                            if ($diff < 0) {
                              $color = 'color: red;';
                            }

                            $labels_chart .= $title->tax_name . '||';
                            $datasets1 .= $sum[$title->tax_id]->tax_estimate . '||';
                            $datasets2 .= $sum[$title->tax_id]->receive_amount . '||';
                            // echo("<pre>");
                            // print_r($getrec);
                            // echo("</pre>");
  

                            $sum1 += (@$sum[$title->tax_id]->tax_estimate);
                            $sum2 += (@$sum[$title->tax_id]->receive_amount);
                            ?>

                              <tr>
                                <td><?php echo $title->tax_name ?></td>
                                <td style="text-align:right"><?php echo number_format(@$sum[$title->tax_id]->tax_estimate, 2); ?></td> 
                                <td style="text-align:right"><?php echo number_format(@$sum[$title->tax_id]->receive_amount, 2); ?></td>  
                                <td style="text-align:right;<?php echo $color; ?>"><?php echo number_format($diff, 2); ?></td>   
                              </tr>
                           <?php 
                        }
                        $labels_chart = substr($labels_chart, 0, -2);
                        $datasets1 = substr($datasets1, 0, -2);
                        $datasets2 = substr($datasets2, 0, -2); 

                        $diff = $sum2 - $sum1;
                        if ($diff < 0) {
                          $color = 'color: red;';
                        }
                        ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td align="center">รวม</td>
                                <td align="right"><?php echo number_format($sum1, 2); ?></td>
                                <td align="right"><?php echo number_format($sum2, 2); ?></td>
                                <td align="right" style="<?php echo $color;?>"><?php echo number_format($diff , 2); ?></td>
                              </tr>
                            </tfoot>
                            </table>
                            <input type="hidden" id="labels_chart" value="<?php echo $labels_chart; ?>">
                            <input type="hidden" id="datasets1" value="<?php echo $datasets1; ?>">
                            <input type="hidden" id="datasets2" value="<?php echo $datasets2; ?>">
                        </div> 
                        <div class="col-md-6 col-sm-12 col-xs-12" style="text-align: right;">
                          <a id="chart_download" download="ChartJpg.jpg" type="button" class="btn btn-success" title="ดาวน์โหลด "> <i class="fa fa-file-image-o"> </i> ดาวน์โหลด</a>
                          <!-- <a class="btn btn-default btn-xs" id="chart_download" download="ChartJpg.jpg"><i class="fa fa-file-image-o"></i> ดาวน์โหลด</a> -->
                        <div >
                          <canvas id="report_receive" ></canvas>
                        </div>
                    </div>
                 </div>
                 </div>    

               <div class="x_content">
                <div class="col-md-6 col-sm-4 col-xs-4">
                      <!-- <h3>รายงานบัญชีรายรับ</h3> -->
                  </div>
                  <div class="col-md-6 col-sm-8 col-xs-8 text-right" style="margin-bottom: 7px; padding-right: 0;">
                      <div class="btn-group">
                          <button onclick="window.open('<?php echo base_url('export_report/report_rec?type=pdf');?>');" type="button" class="btn btn-success" title="ส่งออก pdf"> <i class="fa fa-file-pdf-o"> </i> ส่งออก pdf
                          </button>
                          <button onclick="window.open('<?php echo base_url('export_report/report_rec');?>');" type="button" class="btn btn-success" title="ส่งออก excel"> <i class="fa fa-file-excel-o"> </i> ส่งออก excel
                          </button>
                      </div>
                  </div>
                
                 <br>
                 <table class="table table-bordered table-striped ">
                      <thead>
                        <tr>
                          <th style="width:40%">รายการ</th>
                          <th style="width:20%">ประมานการรายรับ</th>
                          <th style="width:20%">รายรับจริง</th>
                          <th style="width:20%">+สูง -ต่ำ</th>
                        </tr>

                      </thead>
                      <tbody>
                        <?php foreach ($getrec[0] as $key => $title) {
                          $diff = $sum[$title->tax_id]->receive_amount - $sum[$title->tax_id]->tax_estimate ;
                          $color = '';
                          if ($diff < 0) {
                            $color = 'color: red;';
                          }
                          ?>

                          <tr>
                            <td style="font-weight:bolder;"> <?php echo $title->tax_name; ?></td>
                            <td style="font-weight:bolder;text-align:right"><?php echo number_format(@$sum[$title->tax_id]->tax_estimate, 2); ?></td> 
                            <td style="font-weight:bolder;text-align:right"><?php echo number_format(@$sum[$title->tax_id]->receive_amount, 2); ?></td>  
                            <td style="font-weight:bolder;text-align:right;<?php echo $color; ?>"><?php echo number_format($diff, 2); ?></td>  
                          </tr>
                           <?php foreach ($getrec[$title->tax_id] as $key => $title2) {
                              // echo("<pre>");
                              // print_r($title2);
                              // echo("</pre>");
                             
                            $diff = $title2->receive_amount - $title2->tax_estimate;
                            $color = '';
                            if ($diff < 0) {
                              $color = 'color: red;';
                            }
                            ?>
                             
                    
                          <tr>
                         <td style="padding-left: 20px;"><?php echo $title2->tax_name; ?></td>              
                         <td style="text-align:right"><?php echo number_format(@$title2->tax_estimate, 2); ?></td> 
                         <td style="text-align:right"><?php echo number_format(@$title2->receive_amount, 2); ?></td>      
                         <td style="text-align:right; <?php echo $color; ?>"><?php echo number_format($diff, 2); ?></td>     
                                   
                         </tr>


                      <?php 
                    }
                  }

                    $diff = $sum2 - $sum1;
                    if ($diff < 0) {
                      $color = 'color: red;';
                    }
                  ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td align="center">รวม</td>
                          <td align="right"><?php echo number_format($sum1, 2); ?></td>
                          <td align="right"><?php echo number_format($sum2, 2); ?></td>
                          <td align="right" style="<?php echo $color;?>"><?php echo number_format($diff, 2); ?></td>
                        </tr>
                      </tfoot>
        
                  </table>
                </div>
                    
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>

<style>
th{
  text-align: center;
background-color:#2A3F54;
color: #FFF;
}


</style>


