<?php
$class = 'grid_left admin-dashboard-chart';
$class_pass = 'admin-dashboard-pass-usage-chart';
$arrow = '<i class="pull-right icon-chevron-up grayc"></i>';
if (isset($this->request->params['named']['is_ajax_load'])) {
$arrow = '<i class="icon-chevron-down pull-right grayc"></i>';
}		
?>
<div class="js-cache-load-admin-charts">
	<section class="thumbnail no-pad top-mspace bot-mspace sep  ">
            <div class="no-mar no-bor clearfix box-head space sep-bot bootstro" data-bootstro-step="13" data-bootstro-content="<?php echo __l("A page view is an instance of a page being loaded by a browser. The Page views metric is the total number of pages viewed; repeated views of a single page are also counted. Visitors is number of user visit the site. Bounces represents the percentage of visitors who enter the site and 'bounce' (leave the site) rather than continue viewing other pages within the site. Also it shows the graphical representation of the already existing user's visit and new user visit rate. Recent Activity shows the last 3 site activities. To see the list of all activities please click 'More' button. User engagment shows current status site users. An overview of site activities such as registrations, logins, posts, revenue and performance comparison with previous period");?>" data-bootstro-placement='bottom' data-bootstro-width="600px" >
              <h5 class="pull-left"><i class="icon-bar-chart pinkc no-bg"></i><?php echo __l('Overview'); ?></h5>
              <div class="pull-right"> <a href="#collapseOne" data-parent="#accordion2" data-toggle="collapse" class="pull-right blackc accordion-toggle js-toggle-icon"><?php echo $arrow; ?></a>
			  <div class="navbar pull-right no-mar">
                <ul class="nav no-mar pull-right">
                  <li class=""> <span id="setting5" class="dropdown-toggle cur no-under" data-toggle="dropdown"><i class="icon-wrench grayc"></i></span>
                    <ul aria-labelledby="setting5" class="dropdown-menu">
                      <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/contest_charts/chart_transactions/select_range_id:lastDays/is_ajax_load:1/";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/contest_charts/chart_transactions/select_range_id:lastWeeks/is_ajax_load:1/";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/contest_charts/chart_transactions/select_range_id:lastMonths/is_ajax_load:1/";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>> <a class='js-link-chart js-no-pjax {"data_load":"js-overview-transaction"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/contest_charts/chart_transactions/select_range_id:lastYears/is_ajax_load:1/";?>"><?php echo __l('Last 3 years'); ?></a> </li>
                    </ul>
                  </li>
                </ul>
              </div>
                <div class="dropdown pull-right open"> 
                  
                </div>
              </div>
            </div>
		<div id="collapseOne" class="row-fluid accordion-body in collapse" style="height: auto; ">
			  <section class="span10">
                <div class="space dc"> <div class="js-load-line-graph grid_left chart-half-section {'data_container':'transactions_line_data', 'chart_container':'transactions_line_chart', 'chart_title':'<?php echo __l('Transactions') ;?>', 'chart_y_title': '<?php echo __l('Amount');?>'}">
										<div class="dashboard-tl">
											<div class="dashboard-tr">
												<div class="dashboard-tc">
												</div>
											</div>
										</div>
										<div class="dashboard-cl">
											<div class="dashboard-cr">
												<div class="dashboard-cc clearfix">
													<div id="transactions_line_chart" class="<?php echo $class; ?>"></div>
													<div class="hide">
														<table id="transactions_line_data" class="list">
															<thead>
																<tr>
																	<th><?php echo __l('Period'); ?></th>
<?php foreach($chart_transactions_periods as $_period): ?>
																	<th><?php echo $_period['display']; ?></th>
<?php endforeach; ?>
																</tr>
															</thead>
															<tbody>
<?php foreach($chart_transactions_data as $display_name => $chart_data): ?>
																<tr>
																	<th><?php echo $display_name; ?></th>
<?php foreach($chart_data as $val): ?>
																	<td><?php echo $val; ?></td>
<?php endforeach; ?>
																</tr>
<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="dashboard-bl">
											<div class="dashboard-br">
												<div class="dashboard-bc">
												</div>
											</div>
										</div>
									</div> </div>
              </section>
              <section class="span10 sep-left">
                <div class="space dc"> <div class="js-load-line-graph grid_left chart-half-section {'data_container':'contest_line_data', 'chart_container':'contest_line_chart', 'chart_title':'<?php echo __l('Contests') ;?>', 'chart_y_title': '<?php echo __l('Contests');?>'}">
										<div class="dashboard-tl">
											<div class="dashboard-tr">
												<div class="dashboard-tc"></div>
											</div>
										</div>
										<div class="dashboard-cl">
											<div class="dashboard-cr">
												<div class="dashboard-cc clearfix">
													<div id="contest_line_chart" class="<?php echo $class; ?>"></div>
													<div class="hide">
														<table id="contest_line_data" class="list">
															<thead>
																<tr>
																	<th><?php echo __l('Period'); ?></th>
<?php foreach($chart_contest_status_periods as $_period): ?>
																	<th><?php echo $_period['display']; ?></th>
<?php endforeach; ?>
																</tr>
															</thead>
															<tbody>
<?php foreach($chart_contest_status_data as $display_name => $chart_data): ?>
																<tr>
																	<th><?php echo $display_name; ?></th>
<?php foreach($chart_data as $val): ?>
																	<td><?php echo $val; ?></td>
<?php endforeach; ?>
																</tr>
<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="dashboard-bl">
											<div class="dashboard-br">
												<div class="dashboard-bc"></div>
											</div>
										</div>
									</div> </div>
              </section>
			  <section class="span10">
                <div class="space dc"> <div class="js-load-line-graph grid_left chart-half-section {'data_container':'entries_line_data', 'chart_container':'entries_line_chart', 'chart_title':'<?php echo __l('Entries') ;?>', 'chart_y_title': '<?php echo __l('Entries');?>'}">
										<div class="dashboard-tl">
											<div class="dashboard-tr">
												<div class="dashboard-tc"></div>
											</div>
										</div>
										<div class="dashboard-cl">
											<div class="dashboard-cr">
												<div class="dashboard-cc clearfix">
													<div id="entries_line_chart" class="<?php echo $class; ?>"></div>
													<div class="hide">
														<table id="entries_line_data" class="list">
															<thead>
																<tr>
																	<th><?php echo __l('Period'); ?></th>
<?php foreach($chart_contest_user_status_periods as $_period): ?>
																	<th><?php echo $_period['display']; ?></th>
<?php endforeach; ?>
																</tr>
															</thead>
															<tbody>
<?php foreach($chart_contest_user_status_data as $display_name => $chart_data): ?>
																<tr>
																	<th><?php echo $display_name; ?></th>
<?php foreach($chart_data as $val): ?>
																	<td><?php echo $val; ?></td>
<?php endforeach; ?>
																</tr>
<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="dashboard-bl">
											<div class="dashboard-br">
												<div class="dashboard-bc"></div>
											</div>
										</div>
									</div> </div>
              </section>
            </div>
		
          </section>
		  </div>