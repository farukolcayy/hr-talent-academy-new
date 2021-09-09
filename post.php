
 <?php
 /* Bağlantıyı Başlat */
 $mysqli = new mysqli("localhost","hrtalent_basvuru","!hrt!2021!","hrtalent_basvuru_2021");/* Bağlantıyı Kontrol Et */
 if ($mysqli->connect_error){
     /* Bağlantı Başarısız İse */
     echo "Bağlantı Başarısız. Hata: " . $mysqli->connect_error;
     exit;
 }

   $name = $_POST['name'];
   $surname = $_POST['surname'];
   $email = $_POST['email'];
   $tel = $_POST['tel'];
   $school_name = $_POST['school_name'];
   $school_department = $_POST['school_department'];
   $className = $_POST['className'];
   


  if(!empty($name) && !empty($surname) && !empty($email) && !empty($tel) && !empty($school_name) && $school_name!="Üniversite Seçiniz..." && !empty($school_department) && !empty($className) && $className!="Sınıf Seçiniz..."  ){
      $sql= "INSERT INTO basvuru (name,surname,emailAddress,phoneNumber,university,department,class) VALUES ('$name','$surname','$email','$tel','$school_name','$school_department','$className')";
     
    
      mysqli_set_charset($mysqli,"utf8");
        
      if(mysqli_query($mysqli, $sql))
      {
          echo "Sorunuz iletildi";
      } 
      else
      {
          echo "Hata: Sorunuz iletilemedi!";
          
      }

    }
    else
     {
    echo "Tüm alanlar doldurulmalı!";
     }




 $mysqli->close();
 ?>

