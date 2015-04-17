<?php
include '../includes/session.php';

$stmt1 = $mysqli->prepare("SELECT s.email, d.firstname, d.surname, d.gender, d.studentno, d.degree, f.fee_amount, d.nationality, DATE_FORMAT(d.dateofbirth,'%d/%m/%Y') as dateofbirth, d.phonenumber, d.address1, d.address2, d.town, d.city, d.postcode FROM user_signin s LEFT JOIN user_detail d ON s.userid=d.userid LEFT JOIN user_fee f ON s.userid=f.userid WHERE s.userid = ? LIMIT 1");
$stmt1->bind_param('i', $session_userid);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($email, $firstname, $surname, $gender, $studentno, $degree, $fee_amount, $nationality, $dateofbirth, $phonenumber, $address1, $address2, $town, $city, $postcode);
$stmt1->fetch();

if ($dateofbirth == "0000-00-00") {
    $dateofbirth = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include '../assets/meta-tags.php'; ?>

	<?php include '../assets/css-paths/common-css-paths.php'; ?>

    <title>Student Portal | Update Account</title>
	
</head>

<body>

	<div class="preloader"></div>

	<?php if (isset($_SESSION['signedIn']) && $_SESSION['signedIn'] == true) : ?>

    <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'student') : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
	<li><a href="../../home/">Home</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Update account</li>
    </ol>

	<!-- Update account -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updateaccount_form" novalidate>

	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>First name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter your first name">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Surname<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter your surname">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="gender">Gender<span class="field-required">*</span></label>
    <select class="form-control" name="gender" id="gender" style="width: 100%;">
        <option <?php if($gender == "male") echo "selected"; ?>>Male</option>
        <option <?php if($gender == "female") echo "selected"; ?>>Female</option>
        <option <?php if($gender == "other") echo "selected"; ?>>Other</option>
    </select>
    </div>
    </div>

    <div class="form-group">
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="studentno">Student number<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="studentno" id="studentno" value="<?php echo $studentno; ?>" placeholder="Enter a student number" readonly="readonly">
	</div>
	<div class="col-xs-6 col-sm-6 full-width">
	<label for="degree">Programme of Study<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="degree" id="degree" value="<?php echo $degree; ?>" placeholder="Enter a programme of study" readonly="readonly">
	</div>
	</div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
	<label for="fee_amount">Course fee amount (&pound;)<span class="field-required">*</span></label>
	<input class="form-control" type="text" name="fee_amount" id="fee_amount" value="<?php echo $fee_amount; ?>" placeholder="Enter an amount" readonly="readonly">
	</div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label>Email address<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter a email address">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="nationality">Nationality</label>
    <select class="form-control" name="nationality" id="nationality" style="width: 100%;">
        <option></option>
        <option <?php if($nationality == "afghan") echo "selected"; ?>>Afghan</option>
        <option <?php if($nationality == "albanian") echo "selected"; ?>>Albanian</option>
        <option <?php if($nationality == "algerian") echo "selected"; ?>>Algerian</option>
        <option <?php if($nationality == "american") echo "selected"; ?>>American</option>
        <option <?php if($nationality == "andorran") echo "selected"; ?>>Andorran</option>
        <option <?php if($nationality == "angolan") echo "selected"; ?>>Angolan</option>
        <option <?php if($nationality == "antiguans") echo "selected"; ?>>Antiguans</option>
        <option <?php if($nationality == "argentinean") echo "selected"; ?>>Argentinean</option>
        <option <?php if($nationality == "armenian") echo "selected"; ?>>Armenian</option>
        <option <?php if($nationality == "australian") echo "selected"; ?>>Australian</option>
        <option <?php if($nationality == "austrian") echo "selected"; ?>>Austrian</option>
        <option <?php if($nationality == "azerbaijani") echo "selected"; ?>>Azerbaijani</option>
        <option <?php if($nationality == "bahamian") echo "selected"; ?>>Bahamian</option>
        <option <?php if($nationality == "bahraini") echo "selected"; ?>>Bahraini</option>
        <option <?php if($nationality == "bangladeshi") echo "selected"; ?>>Bangladeshi</option>
        <option <?php if($nationality == "barbadian") echo "selected"; ?>>Barbadian</option>
        <option <?php if($nationality == "barbudans") echo "selected"; ?>>Barbudans</option>
        <option <?php if($nationality == "batswana") echo "selected"; ?>>Batswana</option>
        <option <?php if($nationality == "belarusian") echo "selected"; ?>>Belarusian</option>
        <option <?php if($nationality == "belgian") echo "selected"; ?>>Belgian</option>
        <option <?php if($nationality == "belizean") echo "selected"; ?>>Belizean</option>
        <option <?php if($nationality == "beninese") echo "selected"; ?>>Beninese</option>
        <option <?php if($nationality == "bhutanese") echo "selected"; ?>>Bhutanese</option>
        <option <?php if($nationality == "bolivian") echo "selected"; ?>>Bolivian</option>
        <option <?php if($nationality == "bosnian") echo "selected"; ?>>Bosnian</option>
        <option <?php if($nationality == "brazilian") echo "selected"; ?>>Brazilian</option>
        <option <?php if($nationality == "british") echo "selected"; ?>>British</option>
        <option <?php if($nationality == "bruneian") echo "selected"; ?>>Bruneian</option>
        <option <?php if($nationality == "bulgarian") echo "selected"; ?>>Bulgarian</option>
        <option <?php if($nationality == "burkinabe") echo "selected"; ?>>Burkinabe</option>
        <option <?php if($nationality == "burmese") echo "selected"; ?>>Burmese</option>
        <option <?php if($nationality == "burundian") echo "selected"; ?>>Burundian</option>
        <option <?php if($nationality == "cambodian") echo "selected"; ?>>Cambodian</option>
        <option <?php if($nationality == "cameroonian") echo "selected"; ?>>Cameroonian</option>
        <option <?php if($nationality == "canadian") echo "selected"; ?>>Canadian</option>
        <option <?php if($nationality == "cape verdean") echo "selected"; ?>>Cape Verdean</option>
        <option <?php if($nationality == "central african") echo "selected"; ?>>Central African</option>
        <option <?php if($nationality == "chadian") echo "selected"; ?>>Chadian</option>
        <option <?php if($nationality == "chilean") echo "selected"; ?>>Chilean</option>
        <option <?php if($nationality == "chinese") echo "selected"; ?>>Chinese</option>
        <option <?php if($nationality == "colombian") echo "selected"; ?>>Colombian</option>
        <option <?php if($nationality == "comoran") echo "selected"; ?>>Comoran</option>
        <option <?php if($nationality == "congolese") echo "selected"; ?>>Congolese</option>
        <option <?php if($nationality == "costa rican") echo "selected"; ?>>Costa Rican</option>
        <option <?php if($nationality == "croatian") echo "selected"; ?>>Croatian</option>
        <option <?php if($nationality == "cuban") echo "selected"; ?>>Cuban</option>
        <option <?php if($nationality == "cypriot") echo "selected"; ?>>Cypriot</option>
        <option <?php if($nationality == "czech") echo "selected"; ?>>Czech</option>
        <option <?php if($nationality == "danish") echo "selected"; ?>>Danish</option>
        <option <?php if($nationality == "djibouti") echo "selected"; ?>>Djibouti</option>
        <option <?php if($nationality == "dominican") echo "selected"; ?>>Dominican</option>
        <option <?php if($nationality == "dutch") echo "selected"; ?>>Dutch</option>
        <option <?php if($nationality == "east Timorese") echo "selected"; ?>>East Timorese</option>
        <option <?php if($nationality == "ecuadorean") echo "selected"; ?>>Ecuadorean</option>
        <option <?php if($nationality == "egyptian") echo "selected"; ?>>Egyptian</option>
        <option <?php if($nationality == "emirian") echo "selected"; ?>>Emirian</option>
        <option <?php if($nationality == "equatorial guinean") echo "selected"; ?>>Equatorial Guinean</option>
        <option <?php if($nationality == "eritrean") echo "selected"; ?>>Eritrean</option>
        <option <?php if($nationality == "estonian") echo "selected"; ?>>Estonian</option>
        <option <?php if($nationality == "ethiopian") echo "selected"; ?>>Ethiopian</option>
        <option <?php if($nationality == "fijian") echo "selected"; ?>>Fijian</option>
        <option <?php if($nationality == "filipino") echo "selected"; ?>>Filipino</option>
        <option <?php if($nationality == "finnish") echo "selected"; ?>>Finnish</option>
        <option <?php if($nationality == "french") echo "selected"; ?>>French</option>
        <option <?php if($nationality == "gabonese") echo "selected"; ?>>Gabonese</option>
        <option <?php if($nationality == "gambian") echo "selected"; ?>>Gambian</option>
        <option <?php if($nationality == "georgian") echo "selected"; ?>>Georgian</option>
        <option <?php if($nationality == "german") echo "selected"; ?>>German</option>
        <option <?php if($nationality == "ghanaian") echo "selected"; ?>>Ghanaian</option>
        <option <?php if($nationality == "greek") echo "selected"; ?>>Greek</option>
        <option <?php if($nationality == "grenadian") echo "selected"; ?>>Grenadian</option>
        <option <?php if($nationality == "guatemalan") echo "selected"; ?>>Guatemalan</option>
        <option <?php if($nationality == "guinea-bissauan ") echo "selected"; ?>>Guinea-Bissauan</option>
        <option <?php if($nationality == "guinean") echo "selected"; ?>>Guinean</option>
        <option <?php if($nationality == "guyanese") echo "selected"; ?>>Guyanese</option>
        <option <?php if($nationality == "haitian") echo "selected"; ?>>Haitian</option>
        <option <?php if($nationality == "herzegovinian") echo "selected"; ?>>Herzegovinian</option>
        <option <?php if($nationality == "honduran") echo "selected"; ?>>Honduran</option>
        <option <?php if($nationality == "hungarian") echo "selected"; ?>>Hungarian</option>
        <option <?php if($nationality == "icelander") echo "selected"; ?>>Icelander</option>
        <option <?php if($nationality == "indian") echo "selected"; ?>>Indian</option>
        <option <?php if($nationality == "indonesian") echo "selected"; ?>>Indonesian</option>
        <option <?php if($nationality == "iranian") echo "selected"; ?>>Iranian</option>
        <option <?php if($nationality == "iraqi") echo "selected"; ?>>Iraqi</option>
        <option <?php if($nationality == "irish") echo "selected"; ?>>Irish</option>
        <option <?php if($nationality == "israeli") echo "selected"; ?>>Israeli</option>
        <option <?php if($nationality == "italian") echo "selected"; ?>>Italian</option>
        <option <?php if($nationality == "ivorian") echo "selected"; ?>>Ivorian</option>
        <option <?php if($nationality == "jamaican") echo "selected"; ?>>Jamaican</option>
        <option <?php if($nationality == "japanese") echo "selected"; ?>>Japanese</option>
        <option <?php if($nationality == "jordanian") echo "selected"; ?>>Jordanian</option>
        <option <?php if($nationality == "kazakhstani") echo "selected"; ?>>Kazakhstani</option>
        <option <?php if($nationality == "kenyan") echo "selected"; ?>>Kenyan</option>
        <option <?php if($nationality == "kittian  and Nevisian") echo "selected"; ?>>Kittian and Nevisian</option>
        <option <?php if($nationality == "kuwaiti") echo "selected"; ?>>Kuwaiti</option>
        <option <?php if($nationality == "kyrgyz") echo "selected"; ?>>Kyrgyz</option>
        <option <?php if($nationality == "laotian") echo "selected"; ?>>Laotian</option>
        <option <?php if($nationality == "latvian") echo "selected"; ?>>Latvian</option>
        <option <?php if($nationality == "lebanese") echo "selected"; ?>>Lebanese</option>
        <option <?php if($nationality == "liberian") echo "selected"; ?>>Liberian</option>
        <option <?php if($nationality == "libyan") echo "selected"; ?>>Libyan</option>
        <option <?php if($nationality == "liechtensteiner") echo "selected"; ?>>Liechtensteiner</option>
        <option <?php if($nationality == "lithuanian") echo "selected"; ?>>Lithuanian</option>
        <option <?php if($nationality == "luxembourger") echo "selected"; ?>>Luxembourger</option>
        <option <?php if($nationality == "macedonian") echo "selected"; ?>>Macedonian</option>
        <option <?php if($nationality == "malagasy") echo "selected"; ?>>Malagasy</option>
        <option <?php if($nationality == "malawian") echo "selected"; ?>>Malawian</option>
        <option <?php if($nationality == "malaysian") echo "selected"; ?>>Malaysian</option>
        <option <?php if($nationality == "maldivan") echo "selected"; ?>>Maldivan</option>
        <option <?php if($nationality == "malian") echo "selected"; ?>>Malian</option>
        <option <?php if($nationality == "maltese") echo "selected"; ?>>Maltese</option>
        <option <?php if($nationality == "marshallese") echo "selected"; ?>>Marshallese</option>
        <option <?php if($nationality == "mauritanian") echo "selected"; ?>>Mauritanian</option>
        <option <?php if($nationality == "mauritian") echo "selected"; ?>>Mauritian</option>
        <option <?php if($nationality == "mexican") echo "selected"; ?>>Mexican</option>
        <option <?php if($nationality == "micronesian") echo "selected"; ?>>Micronesian</option>
        <option <?php if($nationality == "moldovan") echo "selected"; ?>>Moldovan</option>
        <option <?php if($nationality == "monacan") echo "selected"; ?>>Monacan</option>
        <option <?php if($nationality == "mongolian") echo "selected"; ?>>Mongolian</option>
        <option <?php if($nationality == "moroccan") echo "selected"; ?>>Moroccan</option>
        <option <?php if($nationality == "mosotho") echo "selected"; ?>>Mosotho</option>
        <option <?php if($nationality == "motswana") echo "selected"; ?>>Motswana</option>
        <option <?php if($nationality == "mozambican") echo "selected"; ?>>Mozambican</option>
        <option <?php if($nationality == "namibian") echo "selected"; ?>>Namibian</option>
        <option <?php if($nationality == "nauruan") echo "selected"; ?>>Nauruan</option>
        <option <?php if($nationality == "nepalese") echo "selected"; ?>>Nepalese</option>
        <option <?php if($nationality == "new zealander") echo "selected"; ?>>New Zealander</option>
        <option <?php if($nationality == "ni-vanuatu") echo "selected"; ?>>Ni-Vanuatu</option>
        <option <?php if($nationality == "nicaraguan") echo "selected"; ?>>Nicaraguan</option>
        <option <?php if($nationality == "nigerien") echo "selected"; ?>>Nigerien</option>
        <option <?php if($nationality == "north korean") echo "selected"; ?>>North Korean</option>
        <option <?php if($nationality == "northern irish") echo "selected"; ?>>Northern Irish</option>
        <option <?php if($nationality == "norwegian") echo "selected"; ?>>Norwegian</option>
        <option <?php if($nationality == "omani") echo "selected"; ?>>Omani</option>
        <option <?php if($nationality == "pakistani") echo "selected"; ?>>Pakistani</option>
        <option <?php if($nationality == "palauan") echo "selected"; ?>>Palauan</option>
        <option <?php if($nationality == "panamanian") echo "selected"; ?>>Panamanian</option>
        <option <?php if($nationality == "papua new guinean") echo "selected"; ?>>Papua New Guinean</option>
        <option <?php if($nationality == "paraguayan") echo "selected"; ?>>Paraguayan</option>
        <option <?php if($nationality == "peruvian") echo "selected"; ?>>Peruvian</option>
        <option <?php if($nationality == "polish") echo "selected"; ?>>Polish</option>
        <option <?php if($nationality == "portuguese") echo "selected"; ?>>Portuguese</option>
        <option <?php if($nationality == "qatari") echo "selected"; ?>>Qatari</option>
        <option <?php if($nationality == "romanian") echo "selected"; ?>>Romanian</option>
        <option <?php if($nationality == "russian") echo "selected"; ?>>Russian</option>
        <option <?php if($nationality == "rwandan") echo "selected"; ?>>Rwandan</option>
        <option <?php if($nationality == "saint lucian") echo "selected"; ?>>Saint Lucian</option>
        <option <?php if($nationality == "salvadoran") echo "selected"; ?>>Salvadoran</option>
        <option <?php if($nationality == "samoan") echo "selected"; ?>>Samoan</option>
        <option <?php if($nationality == "san marinese") echo "selected"; ?>>San Marinese</option>
        <option <?php if($nationality == "sao tomean") echo "selected"; ?>>Sao Tomean</option>
        <option <?php if($nationality == "saudi") echo "selected"; ?>>Saudi</option>
        <option <?php if($nationality == "scottish") echo "selected"; ?>>Scottish</option>
        <option <?php if($nationality == "senegalese") echo "selected"; ?>>Senegalese</option>
        <option <?php if($nationality == "serbian") echo "selected"; ?>>Serbian</option>
        <option <?php if($nationality == "seychellois") echo "selected"; ?>>Seychellois</option>
        <option <?php if($nationality == "sierra leonean") echo "selected"; ?>>Sierra Leonean</option>
        <option <?php if($nationality == "singaporean") echo "selected"; ?>>Singaporean</option>
        <option <?php if($nationality == "slovakian") echo "selected"; ?>>Slovakian</option>
        <option <?php if($nationality == "slovenian") echo "selected"; ?>>Slovenian</option>
        <option <?php if($nationality == "solomon islander") echo "selected"; ?>>Solomon Islander</option>
        <option <?php if($nationality == "somali") echo "selected"; ?>>Somali</option>
        <option <?php if($nationality == "south african") echo "selected"; ?>>South African</option>
        <option <?php if($nationality == "south korean") echo "selected"; ?>>South Korean</option>
        <option <?php if($nationality == "spanish") echo "selected"; ?>>Spanish</option>
        <option <?php if($nationality == "sri lankan") echo "selected"; ?>>Sri Lankan</option>
        <option <?php if($nationality == "sudanese") echo "selected"; ?>>Sudanese</option>
        <option <?php if($nationality == "surinamer") echo "selected"; ?>>Surinamer</option>
        <option <?php if($nationality == "swazi") echo "selected"; ?>>Swazi</option>
        <option <?php if($nationality == "swedish") echo "selected"; ?>>Swedish</option>
        <option <?php if($nationality == "swiss") echo "selected"; ?>>Swiss</option>
        <option <?php if($nationality == "syrian") echo "selected"; ?>>Syrian</option>
        <option <?php if($nationality == "taiwanese") echo "selected"; ?>>Taiwanese</option>
        <option <?php if($nationality == "tajik") echo "selected"; ?>>Tajik</option>
        <option <?php if($nationality == "tanzanian") echo "selected"; ?>>Tanzanian</option>
        <option <?php if($nationality == "thai") echo "selected"; ?>>Thai</option>
        <option <?php if($nationality == "togolese") echo "selected"; ?>>Togolese</option>
        <option <?php if($nationality == "tongan") echo "selected"; ?>>Tongan</option>
        <option <?php if($nationality == "trinidadian or tobagonian") echo "selected"; ?>>Trinidadian or Tobagonian</option>
        <option <?php if($nationality == "tunisian") echo "selected"; ?>>Tunisian</option>
        <option <?php if($nationality == "turkish") echo "selected"; ?>>Turkish</option>
        <option <?php if($nationality == "tuvaluan") echo "selected"; ?>>Tuvaluan</option>
        <option <?php if($nationality == "ugandan") echo "selected"; ?>>Ugandan</option>
        <option <?php if($nationality == "ukrainian") echo "selected"; ?>>Ukrainian</option>
        <option <?php if($nationality == "uruguayan") echo "selected"; ?>>Uruguayan</option>
        <option <?php if($nationality == "uzbekistani") echo "selected"; ?>>Uzbekistani</option>
        <option <?php if($nationality == "venezuelan") echo "selected"; ?>>Venezuelan</option>
        <option <?php if($nationality == "vietnamese") echo "selected"; ?>>Vietnamese</option>
        <option <?php if($nationality == "welsh") echo "selected"; ?>>Welsh</option>
        <option <?php if($nationality == "yemenite") echo "selected"; ?>>Yemenite</option>
        <option <?php if($nationality == "zambian") echo "selected"; ?>>Zambian</option>
        <option <?php if($nationality == "zimbabwean") echo "selected"; ?>>Zimbabwean</option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Date of Birth</label>
    <input class="form-control" type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $dateofbirth; ?>" placeholder="Select a date"/>
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Enter a phone number">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter the address line 1">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter the address line 2 (Optional)">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="<?php echo $town; ?>" placeholder="Enter a town">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="Enter a city">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Country</label>
    <input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" placeholder="Enter a postcode">
    </div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Update account</span></button>
    </div>

	</div>

    </form>

    </div> <!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>




    <?php endif; ?>

    <?php if (isset($_SESSION['account_type']) && ($_SESSION['account_type'] == 'academic staff' || $_SESSION['account_type'] == 'administrator')) : ?>

    <?php include '../includes/menus/portal_menu.php'; ?>

    <div class="container">

    <ol class="breadcrumb breadcrumb-custom">
	<li><a href="../../home/">Home</a></li>
	<li><a href="../../account/">Account</a></li>
    <li class="active">Update account</li>
    </ol>

	<!-- Update account -->
	<form class="form-horizontal form-custom" style="max-width: 100%;" name="updateaccount_form" novalidate>

	<p id="error" class="feedback-sad text-center"></p>
	<p id="success" class="feedback-happy text-center"></p>

	<div id="hide">

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>First name<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Enter your first name">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Surname<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="surname" id="surname" value="<?php echo $surname; ?>" placeholder="Enter your surname">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="gender">Gender<span class="field-required">*</span></label>
    <select class="form-control" name="gender" id="gender" style="width: 100%;">
        <option <?php if($gender == "male") echo "selected"; ?>>Male</option>
        <option <?php if($gender == "female") echo "selected"; ?>>Female</option>
        <option <?php if($gender == "other") echo "selected"; ?>>Other</option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label>Email address<span class="field-required">*</span></label>
    <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter a email address">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-12 col-sm-12 full-width">
    <label for="nationality">Nationality</label>
    <select class="form-control" name="nationality" id="nationality" style="width: 100%;">
        <option></option>
        <option <?php if($nationality == "afghan") echo "selected"; ?>>Afghan</option>
        <option <?php if($nationality == "albanian") echo "selected"; ?>>Albanian</option>
        <option <?php if($nationality == "algerian") echo "selected"; ?>>Algerian</option>
        <option <?php if($nationality == "american") echo "selected"; ?>>American</option>
        <option <?php if($nationality == "andorran") echo "selected"; ?>>Andorran</option>
        <option <?php if($nationality == "angolan") echo "selected"; ?>>Angolan</option>
        <option <?php if($nationality == "antiguans") echo "selected"; ?>>Antiguans</option>
        <option <?php if($nationality == "argentinean") echo "selected"; ?>>Argentinean</option>
        <option <?php if($nationality == "armenian") echo "selected"; ?>>Armenian</option>
        <option <?php if($nationality == "australian") echo "selected"; ?>>Australian</option>
        <option <?php if($nationality == "austrian") echo "selected"; ?>>Austrian</option>
        <option <?php if($nationality == "azerbaijani") echo "selected"; ?>>Azerbaijani</option>
        <option <?php if($nationality == "bahamian") echo "selected"; ?>>Bahamian</option>
        <option <?php if($nationality == "bahraini") echo "selected"; ?>>Bahraini</option>
        <option <?php if($nationality == "bangladeshi") echo "selected"; ?>>Bangladeshi</option>
        <option <?php if($nationality == "barbadian") echo "selected"; ?>>Barbadian</option>
        <option <?php if($nationality == "barbudans") echo "selected"; ?>>Barbudans</option>
        <option <?php if($nationality == "batswana") echo "selected"; ?>>Batswana</option>
        <option <?php if($nationality == "belarusian") echo "selected"; ?>>Belarusian</option>
        <option <?php if($nationality == "belgian") echo "selected"; ?>>Belgian</option>
        <option <?php if($nationality == "belizean") echo "selected"; ?>>Belizean</option>
        <option <?php if($nationality == "beninese") echo "selected"; ?>>Beninese</option>
        <option <?php if($nationality == "bhutanese") echo "selected"; ?>>Bhutanese</option>
        <option <?php if($nationality == "bolivian") echo "selected"; ?>>Bolivian</option>
        <option <?php if($nationality == "bosnian") echo "selected"; ?>>Bosnian</option>
        <option <?php if($nationality == "brazilian") echo "selected"; ?>>Brazilian</option>
        <option <?php if($nationality == "british") echo "selected"; ?>>British</option>
        <option <?php if($nationality == "bruneian") echo "selected"; ?>>Bruneian</option>
        <option <?php if($nationality == "bulgarian") echo "selected"; ?>>Bulgarian</option>
        <option <?php if($nationality == "burkinabe") echo "selected"; ?>>Burkinabe</option>
        <option <?php if($nationality == "burmese") echo "selected"; ?>>Burmese</option>
        <option <?php if($nationality == "burundian") echo "selected"; ?>>Burundian</option>
        <option <?php if($nationality == "cambodian") echo "selected"; ?>>Cambodian</option>
        <option <?php if($nationality == "cameroonian") echo "selected"; ?>>Cameroonian</option>
        <option <?php if($nationality == "canadian") echo "selected"; ?>>Canadian</option>
        <option <?php if($nationality == "cape verdean") echo "selected"; ?>>Cape Verdean</option>
        <option <?php if($nationality == "central african") echo "selected"; ?>>Central African</option>
        <option <?php if($nationality == "chadian") echo "selected"; ?>>Chadian</option>
        <option <?php if($nationality == "chilean") echo "selected"; ?>>Chilean</option>
        <option <?php if($nationality == "chinese") echo "selected"; ?>>Chinese</option>
        <option <?php if($nationality == "colombian") echo "selected"; ?>>Colombian</option>
        <option <?php if($nationality == "comoran") echo "selected"; ?>>Comoran</option>
        <option <?php if($nationality == "congolese") echo "selected"; ?>>Congolese</option>
        <option <?php if($nationality == "costa rican") echo "selected"; ?>>Costa Rican</option>
        <option <?php if($nationality == "croatian") echo "selected"; ?>>Croatian</option>
        <option <?php if($nationality == "cuban") echo "selected"; ?>>Cuban</option>
        <option <?php if($nationality == "cypriot") echo "selected"; ?>>Cypriot</option>
        <option <?php if($nationality == "czech") echo "selected"; ?>>Czech</option>
        <option <?php if($nationality == "danish") echo "selected"; ?>>Danish</option>
        <option <?php if($nationality == "djibouti") echo "selected"; ?>>Djibouti</option>
        <option <?php if($nationality == "dominican") echo "selected"; ?>>Dominican</option>
        <option <?php if($nationality == "dutch") echo "selected"; ?>>Dutch</option>
        <option <?php if($nationality == "east Timorese") echo "selected"; ?>>East Timorese</option>
        <option <?php if($nationality == "ecuadorean") echo "selected"; ?>>Ecuadorean</option>
        <option <?php if($nationality == "egyptian") echo "selected"; ?>>Egyptian</option>
        <option <?php if($nationality == "emirian") echo "selected"; ?>>Emirian</option>
        <option <?php if($nationality == "equatorial guinean") echo "selected"; ?>>Equatorial Guinean</option>
        <option <?php if($nationality == "eritrean") echo "selected"; ?>>Eritrean</option>
        <option <?php if($nationality == "estonian") echo "selected"; ?>>Estonian</option>
        <option <?php if($nationality == "ethiopian") echo "selected"; ?>>Ethiopian</option>
        <option <?php if($nationality == "fijian") echo "selected"; ?>>Fijian</option>
        <option <?php if($nationality == "filipino") echo "selected"; ?>>Filipino</option>
        <option <?php if($nationality == "finnish") echo "selected"; ?>>Finnish</option>
        <option <?php if($nationality == "french") echo "selected"; ?>>French</option>
        <option <?php if($nationality == "gabonese") echo "selected"; ?>>Gabonese</option>
        <option <?php if($nationality == "gambian") echo "selected"; ?>>Gambian</option>
        <option <?php if($nationality == "georgian") echo "selected"; ?>>Georgian</option>
        <option <?php if($nationality == "german") echo "selected"; ?>>German</option>
        <option <?php if($nationality == "ghanaian") echo "selected"; ?>>Ghanaian</option>
        <option <?php if($nationality == "greek") echo "selected"; ?>>Greek</option>
        <option <?php if($nationality == "grenadian") echo "selected"; ?>>Grenadian</option>
        <option <?php if($nationality == "guatemalan") echo "selected"; ?>>Guatemalan</option>
        <option <?php if($nationality == "guinea-bissauan ") echo "selected"; ?>>Guinea-Bissauan</option>
        <option <?php if($nationality == "guinean") echo "selected"; ?>>Guinean</option>
        <option <?php if($nationality == "guyanese") echo "selected"; ?>>Guyanese</option>
        <option <?php if($nationality == "haitian") echo "selected"; ?>>Haitian</option>
        <option <?php if($nationality == "herzegovinian") echo "selected"; ?>>Herzegovinian</option>
        <option <?php if($nationality == "honduran") echo "selected"; ?>>Honduran</option>
        <option <?php if($nationality == "hungarian") echo "selected"; ?>>Hungarian</option>
        <option <?php if($nationality == "icelander") echo "selected"; ?>>Icelander</option>
        <option <?php if($nationality == "indian") echo "selected"; ?>>Indian</option>
        <option <?php if($nationality == "indonesian") echo "selected"; ?>>Indonesian</option>
        <option <?php if($nationality == "iranian") echo "selected"; ?>>Iranian</option>
        <option <?php if($nationality == "iraqi") echo "selected"; ?>>Iraqi</option>
        <option <?php if($nationality == "irish") echo "selected"; ?>>Irish</option>
        <option <?php if($nationality == "israeli") echo "selected"; ?>>Israeli</option>
        <option <?php if($nationality == "italian") echo "selected"; ?>>Italian</option>
        <option <?php if($nationality == "ivorian") echo "selected"; ?>>Ivorian</option>
        <option <?php if($nationality == "jamaican") echo "selected"; ?>>Jamaican</option>
        <option <?php if($nationality == "japanese") echo "selected"; ?>>Japanese</option>
        <option <?php if($nationality == "jordanian") echo "selected"; ?>>Jordanian</option>
        <option <?php if($nationality == "kazakhstani") echo "selected"; ?>>Kazakhstani</option>
        <option <?php if($nationality == "kenyan") echo "selected"; ?>>Kenyan</option>
        <option <?php if($nationality == "kittian  and Nevisian") echo "selected"; ?>>Kittian and Nevisian</option>
        <option <?php if($nationality == "kuwaiti") echo "selected"; ?>>Kuwaiti</option>
        <option <?php if($nationality == "kyrgyz") echo "selected"; ?>>Kyrgyz</option>
        <option <?php if($nationality == "laotian") echo "selected"; ?>>Laotian</option>
        <option <?php if($nationality == "latvian") echo "selected"; ?>>Latvian</option>
        <option <?php if($nationality == "lebanese") echo "selected"; ?>>Lebanese</option>
        <option <?php if($nationality == "liberian") echo "selected"; ?>>Liberian</option>
        <option <?php if($nationality == "libyan") echo "selected"; ?>>Libyan</option>
        <option <?php if($nationality == "liechtensteiner") echo "selected"; ?>>Liechtensteiner</option>
        <option <?php if($nationality == "lithuanian") echo "selected"; ?>>Lithuanian</option>
        <option <?php if($nationality == "luxembourger") echo "selected"; ?>>Luxembourger</option>
        <option <?php if($nationality == "macedonian") echo "selected"; ?>>Macedonian</option>
        <option <?php if($nationality == "malagasy") echo "selected"; ?>>Malagasy</option>
        <option <?php if($nationality == "malawian") echo "selected"; ?>>Malawian</option>
        <option <?php if($nationality == "malaysian") echo "selected"; ?>>Malaysian</option>
        <option <?php if($nationality == "maldivan") echo "selected"; ?>>Maldivan</option>
        <option <?php if($nationality == "malian") echo "selected"; ?>>Malian</option>
        <option <?php if($nationality == "maltese") echo "selected"; ?>>Maltese</option>
        <option <?php if($nationality == "marshallese") echo "selected"; ?>>Marshallese</option>
        <option <?php if($nationality == "mauritanian") echo "selected"; ?>>Mauritanian</option>
        <option <?php if($nationality == "mauritian") echo "selected"; ?>>Mauritian</option>
        <option <?php if($nationality == "mexican") echo "selected"; ?>>Mexican</option>
        <option <?php if($nationality == "micronesian") echo "selected"; ?>>Micronesian</option>
        <option <?php if($nationality == "moldovan") echo "selected"; ?>>Moldovan</option>
        <option <?php if($nationality == "monacan") echo "selected"; ?>>Monacan</option>
        <option <?php if($nationality == "mongolian") echo "selected"; ?>>Mongolian</option>
        <option <?php if($nationality == "moroccan") echo "selected"; ?>>Moroccan</option>
        <option <?php if($nationality == "mosotho") echo "selected"; ?>>Mosotho</option>
        <option <?php if($nationality == "motswana") echo "selected"; ?>>Motswana</option>
        <option <?php if($nationality == "mozambican") echo "selected"; ?>>Mozambican</option>
        <option <?php if($nationality == "namibian") echo "selected"; ?>>Namibian</option>
        <option <?php if($nationality == "nauruan") echo "selected"; ?>>Nauruan</option>
        <option <?php if($nationality == "nepalese") echo "selected"; ?>>Nepalese</option>
        <option <?php if($nationality == "new zealander") echo "selected"; ?>>New Zealander</option>
        <option <?php if($nationality == "ni-vanuatu") echo "selected"; ?>>Ni-Vanuatu</option>
        <option <?php if($nationality == "nicaraguan") echo "selected"; ?>>Nicaraguan</option>
        <option <?php if($nationality == "nigerien") echo "selected"; ?>>Nigerien</option>
        <option <?php if($nationality == "north korean") echo "selected"; ?>>North Korean</option>
        <option <?php if($nationality == "northern irish") echo "selected"; ?>>Northern Irish</option>
        <option <?php if($nationality == "norwegian") echo "selected"; ?>>Norwegian</option>
        <option <?php if($nationality == "omani") echo "selected"; ?>>Omani</option>
        <option <?php if($nationality == "pakistani") echo "selected"; ?>>Pakistani</option>
        <option <?php if($nationality == "palauan") echo "selected"; ?>>Palauan</option>
        <option <?php if($nationality == "panamanian") echo "selected"; ?>>Panamanian</option>
        <option <?php if($nationality == "papua new guinean") echo "selected"; ?>>Papua New Guinean</option>
        <option <?php if($nationality == "paraguayan") echo "selected"; ?>>Paraguayan</option>
        <option <?php if($nationality == "peruvian") echo "selected"; ?>>Peruvian</option>
        <option <?php if($nationality == "polish") echo "selected"; ?>>Polish</option>
        <option <?php if($nationality == "portuguese") echo "selected"; ?>>Portuguese</option>
        <option <?php if($nationality == "qatari") echo "selected"; ?>>Qatari</option>
        <option <?php if($nationality == "romanian") echo "selected"; ?>>Romanian</option>
        <option <?php if($nationality == "russian") echo "selected"; ?>>Russian</option>
        <option <?php if($nationality == "rwandan") echo "selected"; ?>>Rwandan</option>
        <option <?php if($nationality == "saint lucian") echo "selected"; ?>>Saint Lucian</option>
        <option <?php if($nationality == "salvadoran") echo "selected"; ?>>Salvadoran</option>
        <option <?php if($nationality == "samoan") echo "selected"; ?>>Samoan</option>
        <option <?php if($nationality == "san marinese") echo "selected"; ?>>San Marinese</option>
        <option <?php if($nationality == "sao tomean") echo "selected"; ?>>Sao Tomean</option>
        <option <?php if($nationality == "saudi") echo "selected"; ?>>Saudi</option>
        <option <?php if($nationality == "scottish") echo "selected"; ?>>Scottish</option>
        <option <?php if($nationality == "senegalese") echo "selected"; ?>>Senegalese</option>
        <option <?php if($nationality == "serbian") echo "selected"; ?>>Serbian</option>
        <option <?php if($nationality == "seychellois") echo "selected"; ?>>Seychellois</option>
        <option <?php if($nationality == "sierra leonean") echo "selected"; ?>>Sierra Leonean</option>
        <option <?php if($nationality == "singaporean") echo "selected"; ?>>Singaporean</option>
        <option <?php if($nationality == "slovakian") echo "selected"; ?>>Slovakian</option>
        <option <?php if($nationality == "slovenian") echo "selected"; ?>>Slovenian</option>
        <option <?php if($nationality == "solomon islander") echo "selected"; ?>>Solomon Islander</option>
        <option <?php if($nationality == "somali") echo "selected"; ?>>Somali</option>
        <option <?php if($nationality == "south african") echo "selected"; ?>>South African</option>
        <option <?php if($nationality == "south korean") echo "selected"; ?>>South Korean</option>
        <option <?php if($nationality == "spanish") echo "selected"; ?>>Spanish</option>
        <option <?php if($nationality == "sri lankan") echo "selected"; ?>>Sri Lankan</option>
        <option <?php if($nationality == "sudanese") echo "selected"; ?>>Sudanese</option>
        <option <?php if($nationality == "surinamer") echo "selected"; ?>>Surinamer</option>
        <option <?php if($nationality == "swazi") echo "selected"; ?>>Swazi</option>
        <option <?php if($nationality == "swedish") echo "selected"; ?>>Swedish</option>
        <option <?php if($nationality == "swiss") echo "selected"; ?>>Swiss</option>
        <option <?php if($nationality == "syrian") echo "selected"; ?>>Syrian</option>
        <option <?php if($nationality == "taiwanese") echo "selected"; ?>>Taiwanese</option>
        <option <?php if($nationality == "tajik") echo "selected"; ?>>Tajik</option>
        <option <?php if($nationality == "tanzanian") echo "selected"; ?>>Tanzanian</option>
        <option <?php if($nationality == "thai") echo "selected"; ?>>Thai</option>
        <option <?php if($nationality == "togolese") echo "selected"; ?>>Togolese</option>
        <option <?php if($nationality == "tongan") echo "selected"; ?>>Tongan</option>
        <option <?php if($nationality == "trinidadian or tobagonian") echo "selected"; ?>>Trinidadian or Tobagonian</option>
        <option <?php if($nationality == "tunisian") echo "selected"; ?>>Tunisian</option>
        <option <?php if($nationality == "turkish") echo "selected"; ?>>Turkish</option>
        <option <?php if($nationality == "tuvaluan") echo "selected"; ?>>Tuvaluan</option>
        <option <?php if($nationality == "ugandan") echo "selected"; ?>>Ugandan</option>
        <option <?php if($nationality == "ukrainian") echo "selected"; ?>>Ukrainian</option>
        <option <?php if($nationality == "uruguayan") echo "selected"; ?>>Uruguayan</option>
        <option <?php if($nationality == "uzbekistani") echo "selected"; ?>>Uzbekistani</option>
        <option <?php if($nationality == "venezuelan") echo "selected"; ?>>Venezuelan</option>
        <option <?php if($nationality == "vietnamese") echo "selected"; ?>>Vietnamese</option>
        <option <?php if($nationality == "welsh") echo "selected"; ?>>Welsh</option>
        <option <?php if($nationality == "yemenite") echo "selected"; ?>>Yemenite</option>
        <option <?php if($nationality == "zambian") echo "selected"; ?>>Zambian</option>
        <option <?php if($nationality == "zimbabwean") echo "selected"; ?>>Zimbabwean</option>
    </select>
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Date of Birth</label>
    <input class="form-control" type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $dateofbirth; ?>" placeholder="Select a date"/>
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Phone number</label>
    <input class="form-control" type="text" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" placeholder="Enter a phone number">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Address line 1</label>
    <input class="form-control" type="text" name="address1" id="address1" value="<?php echo $address1; ?>" placeholder="Enter the address line 1">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Address 2 line (Optional)</label>
    <input class="form-control" type="text" name="address2" id="address2" value="<?php echo $address2; ?>" placeholder="Enter the address line 2 (Optional)">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Town</label>
    <input class="form-control" type="text" name="town" id="town" value="<?php echo $town; ?>" placeholder="Enter a town">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>City</label>
    <input class="form-control" type="text" name="city" id="city" value="<?php echo $city; ?>" placeholder="Enter a city">
    </div>
    </div>

    <div class="form-group">
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Country</label>
    <input class="form-control" type="text" name="country" id="country" value="United Kingdom" placeholder="Enter a country" readonly="readonly">
    </div>
    <div class="col-xs-6 col-sm-6 full-width">
    <label>Postcode</label>
    <input class="form-control" type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>" placeholder="Enter a postcode">
    </div>
    </div>

    <hr class="hr-custom">

    <div class="text-center">
    <button id="FormSubmit" class="btn btn-primary btn-lg" >Update account</span></button>
    </div>

	</div>

    </form>

    </div> <!-- /container -->

	<?php include '../includes/footers/footer.php'; ?>




    <?php endif; ?>

	<?php else : ?>

    <?php include '../includes/menus/menu.php'; ?>

    <div class="container">
	
    <form class="form-horizontal form-custom">

	<div class="form-logo text-center">
    <i class="fa fa-graduation-cap"></i>
    </div>

    <hr>
    <p class="feedback-sad text-center">Looks like you're not signed in yet. Please Sign in before accessing this area.</p>
    <hr>

    <div class="text-center">
    <a class="btn btn-primary btn-lg" href="/">Sign in</span></a>
	</div>
	
    </form>

    </div>

    <?php include '../includes/footers/footer.php'; ?>

	<?php endif; ?>

	<?php include '../assets/js-paths/common-js-paths.php'; ?>

	<script>
    $(document).ready(function () {
        //select2
        $("#gender").select2({placeholder: "Select an option"});
        $("#nationality").select2({placeholder: "Select an option"});
    });

    // Date Time Picker
    $('#dateofbirth').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    //Ajax call
    $("#FormSubmit").click(function (e) {
    e.preventDefault();
	
	var hasError = false;
	
	var firstname = $("#firstname").val();
	if(firstname === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a first name.");
		$("#firstname").addClass("error-style");
		hasError  = true;
		return false;
	}
	
	var surname = $("#surname").val();
	if(surname === '') {
		$("#error1").show();
        $("#error1").empty().append("Please enter a surname.");
		$("#surname").addClass("error-style");
		hasError  = true;
		return false;
	}

    var gender = $('#gender :selected').html();

	var email = $("#email").val();
	if(email === '') {
		$("#error2").show();
        $("#error2").empty().append("Please enter an email address.");
		$("#email").addClass("error-style");
		hasError  = true;
		return false;
	}

    var nationality = $("#nationality").val();
    var dateofbirth = $("#dateofbirth").val();
	var phonenumber = $("#phonenumber").val();
	var address1 = $("#address1").val();
    var address2 = $("#address2").val();
	var town = $("#town").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var postcode = $("#postcode").val();

    if(hasError == false){

    jQuery.ajax({
	type: "POST",
	url: "https://student-portal.co.uk/includes/processes.php",
    data:'update_firstname='    + firstname +
         '&update_surname='     + surname +
         '&update_gender='      + gender +
         '&update_email='       + email +
         '&update_nationality=' + nationality +
         '&update_dateofbirth=' + dateofbirth +
         '&update_phonenumber=' + phonenumber +
         '&update_address1='    + address1 +
         '&update_address2='    + address2 +
         '&update_town='        + town +
         '&update_city='        + city +
         '&update_country='     + country +
         '&update_postcode='    + postcode,
    success:function(){
		$("#error").hide();
		$("#hide").hide();
		$("#success").empty().append('Your personal details have been updated successfully.');
    },
    error:function (xhr, ajaxOptions, thrownError){
		$("#error").show();
        $("#error").empty().append(thrownError);
    }
	});
    }

    return true;

    });
	</script>

</body>
</html>

