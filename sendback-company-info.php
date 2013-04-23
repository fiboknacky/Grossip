<?php
session_start();
// var_dump($_SESSION['company']);
$details = $_SESSION['company'];
// $details = $company_obj;

echo '<table width=" 100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="center" scope="row"><img name="logo" align="center" src="'.$details->logoUrl.'"></th>
  </tr>';
if (!empty($details->name)){
 	echo '<tr>
    <th scope="row">Name</th>
    <td>'.$details->name.'</td>
  </tr>';
}
if (!empty($details->websiteUrl)){
  echo '<tr>
    <th scope="row">Website</th>
    <td>'.$details->websiteUrl.'</td>
  </tr>';
}
if (!empty($details->industries)){
	echo '<tr>
    <th scope="row">Twitter ID</th>
    <td>'.$details->twitterId.'</td>
  </tr>';
}
if (!empty($details->foundedYear)){
  echo '<tr>
    <th scope="row">Founded Year</th>
    <td>'.$details->foundedYear.'</td>
  </tr>';
}
if (!empty($details->employeeCountRange)){
  echo '<tr>
    <th scope="row">No. of Employees</th>
    <td>'.$details->employeeCountRange->name.'</td>
  </tr>';
}
if (!empty($details->industries)){
  echo '<tr>
    <th scope="row">Industries</th>
    <td>'; 
	$industry_list = array();
	foreach ($details->industries->values as $industry){
		$industry_list[] = $industry->name;
	}
	echo implode(', ', $industry_list).'
 	</td>
  	</tr>';
}
if (!empty($details->ticker)){
	echo '<tr>
    <th scope="row">Ticker (Stock)</th>
    <td>'.$details->ticker.'</td>
  </tr>';
}
echo '</table>';
?>