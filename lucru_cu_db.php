<?php
  // conectare
  $mysqli = new mysqli('localhost', 'root', '', 'ProPHP');

  if(!$mysqli->connect_errno){
    echo "S-a conectat la baza de date ProPHP<br>";
  }

  echo "<b>INSERT</b></br>";
  $nume = "Curteanu";
  $prenume = "Bogdan";

  $insertStatement = $mysqli->prepare("INSERT INTO Membri(nume, prenume) VALUES(?, ?)");
  // "ss" inseamna string, string pentru nume, prenume
  $insertStatement->bind_param("ss", $nume, $prenume);
  $insertStatement->execute();
  $id = $insertStatement->insert_id;
  echo "S-a inserat elementul nr: " . $id . "<br>";

  // selectam ultimul element inserat
  echo "<b>SELECT</b></br>";
  $selectString = "SELECT nume, prenume FROM Membri WHERE id = " . $id . ";";
  echo "Se executa comanda SQL: " . $selectString . "<br>";
  $sqlResult = $mysqli->query($selectString);
  $selectedRow = $sqlResult->fetch_assoc();
  echo "Elementul inserat este: <b>" . $selectedRow['nume'] . ' ' . $selectedRow['prenume'] . "</b><br>";

/*
  de ce nu merge? 
  Eroare:  Uncaught mysqli_sql_exception: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'WHERE id = ?' at line 1
  
  $updateStatement = $mysqli->prepare("UPDATE Membri set nume = ?, WHERE id = ?");
  // "si" inseamna string, integer pentru nume, id
  $updateStatement->bind_param("si", $nume, $id);
  $updateStatement->execute();
*/

  // modificam ultimul element inserat
  echo "<b>UPDATE</b></br>";
  $numeNou = "Bill";
  $updateString = "UPDATE Membri set nume = '" . $numeNou . "' WHERE id = " . $id . ";";
  echo "Se executa comanda SQL: " . $updateString . "<br>";
  $mysqli->query($updateString);

  // selectam elementul modificat
  $selectString = "SELECT nume, prenume FROM Membri WHERE id = " . $id . ";";
  echo "Se executa comanda SQL: " . $selectString . "<br>";
  $sqlResult = $mysqli->query($selectString);
  $selectedRow = $sqlResult->fetch_assoc();
  echo "Elementul modificat este: <b>" . $selectedRow['nume'] . ' ' . $selectedRow['prenume'] . "</b><br>";

  // stergem ultimul element inserat
  echo "<b>DELETE</b></br>";
  $deleteString = "DELETE FROM Membri WHERE id = " . $id . ";";
  echo "Se executa comanda SQL: " . $deleteString . "<br>";
  $sqlResult = $mysqli->query($deleteString);

  // selectam elementul sters
  $selectString = "SELECT nume, prenume FROM Membri WHERE id = " . $id . ";";
  echo "Se executa comanda SQL: " . $selectString . "<br>";
  $sqlResult = $mysqli->query($selectString);
  $selectedCount = $sqlResult->num_rows;
  echo "S-au gasit <b>" . $selectedCount . "</b> rezultate<br>";
?>