<?php
// assume that session has been started in the file calling this one

// var_dump($_SESSION['company']);
$details = $_SESSION['company'];
if (empty($details) || $details==NULL || empty($details->name))
{
  echo 'NO';
  exit;
}
// $details = $company_obj;

echo '<table style="table-layout: fixed;" width=" 100%" border="0" cellspacing="2" cellpadding="0">
  <tr> 
    <th colspan="2"><h3>About '.$details->name.'</h3></th>
  </tr>
  <tr>
    <th colspan="2" align="center" scope="row" bgcolor="#FFFFFF"><img name="logo" align="center" src="'.$details->logoUrl.'"></th>
  </tr>';
if (!empty($details->name)){
 	echo '<tr>
    <th scope="row">Name</th>
    <td>'.$details->name.'</td>
  </tr>';
}
if (!empty($details->websiteUrl)){
  if (stripos($details->websiteUrl,"http://") === FALSE)
    $details->websiteUrl = "http://".$details->websiteUrl;
  echo '<tr>
    <th scope="row">Website</th>
    <td style="word-wrap: break-word"><a href="'.$details->websiteUrl.'" target="_blank">'.$details->websiteUrl.'</a></td>
  </tr>';
}
if (!empty($details->twitterId)){
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
    <th scope="row">Ticker (Stock Exchange)</th>
    <td>'.$details->ticker;
  if (!empty($details->stockExchange)){
    echo ' ('.$details->stockExchange->name.')';
  }
  echo '</td>
  </tr>';
}
echo '</table>';
?>