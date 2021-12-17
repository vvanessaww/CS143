<?php
// get the id parameter from the request
$id = intval($_GET['id']);

// set the Content-Type header to JSON, 
// so that the client knows that we are returning JSON data
header('Content-Type: application/json');

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
  die('Unable to connect to database [' . $db->connect_error . ']'); 
}

$conn = mysqli_connect("localhost", "cs143", "", "class_db");
$sql = "SELECT * FROM People WHERE id = $id";
$result =  mysqli_query($conn, $sql);

if(mysqli_num_rows($result)){
  $isPerson = True;
}
else ($isPerson = False);

$query0 = "SELECT id, orgName, orgDate, orgCity, orgCountry FROM Organizations WHERE id = $id";
$rs0 = $db->query($query0);
$orgName = "";
$orgDate = "";
$orgCity = "";
$orgCountry = "";
while ($row = $rs0->fetch_assoc()) { 
  if ($row['orgName'] != "NULL") {
    $orgName = $row['orgName'];
  }
  if ($row['orgDate'] != "NULL") {
    $date = explode(' ', $row['orgDate']);
    $orgDate = $date[0];
  }
  if ($row['orgCity'] != "NULL") {
    $orgCity = $row['orgCity'];
  }
  if ($row['orgCountry'] != "NULL") {
    $orgCountry = $row['orgCountry'];
  }
}


$query1 = "SELECT id, givenName, familyName, gender, birthDate, birthCity, birthCountry FROM People WHERE id = $id";
$rs1 = $db->query($query1);
$givenName = "";
$familyName = "";
$gender = "";
$birthDate = "";
$birthCity = "";
$birthCountry = "";
while ($row = $rs1->fetch_assoc()) { 
  if ($row['givenName'] != "NULL") {
    $givenName = $row['givenName'];
  }
  if ($row['familyName'] != "NULL") {
    $familyName = $row['familyName'];
  }
  if ($row['gender'] != "NULL") {
    $gender = $row['gender'];
  }
  if ($row['birthDate'] != "NULL") {
    $date = explode(' ', $row['birthDate']);
    $birthDate = $date[0];
  }
  if ($row['birthCity'] != "NULL") {
    $birthCity = $row['birthCity'];
  }
  if ($row['birthCountry'] != "NULL") {
    $birthCountry = $row['birthCountry'];
  }
}

$query2 = "SELECT prizeKey, awardYear, category, sortOrder FROM Prizes WHERE Prizes.id = $id";
$rs2 = $db->query($query2);
$prizes_array = array();
while ($row = $rs2->fetch_assoc()) {
  $prizekey = $row['prizeKey'];
  $awardYear = $row['awardYear'];
  $category = $row['category'];
  $sortOrder = $row['sortOrder'];
  $prizes_array[$prizekey] = (object) 
    [
      "awardYear" => strval($awardYear),
      "category" => (object) ["en" => $category],
      "sortOrder" => $sortOrder,
      "affiliations" => array()
    ];
}

$query3 = "SELECT
  Prizes.prizeKey,
  Affiliations.affilKey,
  Affiliations.name,
  Affiliations.city,
  Affiliations.country
FROM
  Prizes
  LEFT JOIN Affiliations on Prizes.prizeKey = Affiliations.prizeKey
WHERE
  Prizes.id = $id AND name IS NOT NULL AND city IS NOT NULL AND country IS NOT NULL";
$rs3 = $db->query($query3);
$aff_array = array();
while($row = $rs3->fetch_assoc()) {
  $prizeKey = $row['prizeKey'];
  $name = $row['name'];
  $city = $row['city'];
  $country = $row['country'];
  if (array_key_exists($prizeKey, $prizes_array))
  {
  array_push($aff_array, (object)
  [
    "name" => (object) ["en" => $name],
    "city" => (object) ["en" => $city],
    "country" => (object) ["en" => $country]

]);
  $prizes_array[$prizeKey]->{'affiliations'} = $aff_array;

  }

  // $prizes_array[$prizekey] = (object) 
  // [
  //   "awardYear" => strval($awardYear),
  //   "category" => (object) ["en" => $category],
  //   "sortOrder" => $sortOrder,
  //   "affiliations" => array()
  // ];
  //   $prizes_array[$prizeKey]->{'affiliations'} = array((object) [
  //     "name" => (object) ["en" => $name],
  //     "city" => (object) ["en" => $city],
  //     "country" => (object) ["en" => $country]
  //   ]);
  }

if($isPerson)
{
$output = (object) [
    "id" => strval($id),
    "givenName" => (object) [
        "en" => $givenName
    ],
    "familyName" => (object) [
        "en" => $familyName
    ],
    "gender" =>  $gender,
    "birth" => (object) [
        "date" => $birthDate,
        "place" => (object) [
            "city" => (object) [
                "en" => $birthCity
            ],
            "country" => (object) [
                "en" => $birthCountry
            ]
        ]
    ],
    "nobelPrizes" => array_values($prizes_array)
];
}

else{
  $output = (object) [
      "id" => strval($id),
      "orgName" => (object) [
          "en" => $orgName
      ],
      "founded" => (object) [
          "date" => $orgDate,
          "place" => (object) [
            "city" => (object) [
              "en" => $orgCity
            ],
            "country" => (object) [
              "en" => $orgCountry
            ],
          ],
      ],
      "nobelPrizes" => array_values($prizes_array)
  ];
  }

echo json_encode($output);
mysqli_close($conn);
?>
