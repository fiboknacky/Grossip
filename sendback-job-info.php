<?php
// assume that session has been started in the file calling this one

// var_dump($_SESSION['company']);
$job_list = $_SESSION['joblist'];
$jobs_more_detail = $_SESSION['jobs-more-detail'];
$company_name = $_SESSION['companyname'];
$text_to_mined = "";
if (empty($job_list) || $job_list==NULL || empty($company_name) || empty($job_list))
{
  echo 'NO';
  exit;
}
// $details = $company_obj;
echo '<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
  <tr> 
    <th colspan="2"><h3>Jobs for '.$company_name.'</h3></th>
    </tr></table>';
    $i = 0;
foreach ($job_list as $details){
    if ($i++ == 5)
      break;
    if (empty($details->id))
      continue;
    $more_detail = $jobs_more_detail[$details->id];
    echo '<table width=" 100%" border="0" cellspacing="2" cellpadding="0">
      <tr> 
        <th><b>Job ID</b> '.$details->id.'</th>
      </tr>';
    // if (!empty($details->company->name)){
    //  	echo '<tr>
    //     <td>'.$details->company->name.'</td>
    //   </tr>';
    // }
    if (!empty($more_detail["title"])){
      echo '<tr>
        <td><b>Job Title: </b>'.$more_detail["title"].'</td>
      </tr>';
      if ($i == 1)
      $text_to_mined .= $more_detail["title"]." \n";
    }
    if (!empty($more_detail["jobFunctions"])){
      echo '<tr>
        <td><b>Job Functions: </b>'.$more_detail["jobFunctions"].'</td>
      </tr>';
      if ($i == 1)
      $text_to_mined .= $more_detail["jobFunctions"]." \n";
    }
    if (!empty($details->descriptionSnippet)){
      echo '<tr>
        <td><b>Description: </b>'.$details->descriptionSnippet.'</td>
      </tr>';
      if ($i == 1)
      $text_to_mined .= $details->descriptionSnippet." \n";
    }
    // if (!empty($details->locationDescription)){
    // 	echo '<tr>
    //     <td><b>Location: </b>'.$details->locationDescription.'</td>
    //   </tr>';
    // }
    if (!empty($more_detail["location"])){
      echo '<tr>
        <td><b>Location: </b>'.$more_detail["location"].'</td>
      </tr>';
      if ($i == 1)
      $text_to_mined .= $more_detail["location"]." \n";
    }
    if (!empty($details->jobPoster)){
      echo '<tr>
        <td><b>Posted By: </b>'.$details->jobPoster->firstName.' '.$details->jobPoster->lastName.' ('.$details->jobPoster->headline.')'.'</td>
      </tr>';
    }
    
    echo '<tr><td><br></td></tr></table>';
}
$_SESSION['alchemy-extraction'] = $text_to_mined;
?>