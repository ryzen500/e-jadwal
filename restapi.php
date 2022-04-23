<?php
	$con = mysqli_connect("localhost", "root", "123", "e_jadwal");

if(function_exists($_GET['function'])) {
         $_GET['function']();
      }   
   function getGuru()
   {
      global $con;      
      $query = $con->query("SELECT * FROM guru");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Guru',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }   

 
   function getKelas()
   {
      global $con;      
      $query = $con->query("SELECT * FROM kelas");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Kelas',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }   

   
   function getMapel()
   {
      global $con;      
      $query = $con->query("SELECT * FROM mapel");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Mata Pelajaran',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   } 


   
   function getTahunAjaran()
   {
      global $con;      
      $query = $con->query("SELECT * FROM tahun_ajaran");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Tahun Ajaran',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   } 


   
   
   function getWaktu()
   {
      global $con;      
      $query = $con->query("SELECT * FROM waktu");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Waktu',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   } 
   

   function getHari()
   {
      global $con;      
      $query = $con->query("SELECT * FROM hari");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Menampilkan Data Hari',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
 ?>