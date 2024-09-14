<?php 
if(isset($_GET['id']) && $_GET['act']=='delete'){

    $id = $_GET['id'];
    //echo $id;

    //single roe query แสดงแค่ 1 รายการ จะเอาชื่อไฟล์ภาพไปลบ
    $stmtProductDetail = $condb->prepare("SELECT product_image FROM tbl_product WHERE id=?");
    $stmtProductDetail->execute([$_GET['id']]);
    $row = $stmtProductDetail->fetch(PDO::FETCH_ASSOC);

    //แสดงชื่อไฟล์ภาพ
    // echo 'image name '. $row['product_image'];
    // exit;

    //แสดงจำนวนคิวรี่ที่ได้ row
    // echo $stmtProductDetail->rowCount();
    // exit;

    //สร้างเงื่อนไขในการลบภาพ

    if($stmtProductDetail->rowCount() == 0){
        echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    }else{
        //sql delete
$stmtDelProduct = $condb->prepare('DELETE FROM tbl_product WHERE id=:id');
$stmtDelProduct->bindParam(':id', $id , PDO::PARAM_INT);
$stmtDelProduct->execute();

$condb = null; //close connect db
// echo 'จำนวน row ที่ลบได้'.$stmtDelProduct->rowCount();
if($stmtDelProduct->rowCount() ==1){

    //ลบไฟล์ภาพ
    unlink('../assets/product_img/'.$row['product_image']);


    echo '<script>
         setTimeout(function() {
          swal({
              title: "ลบข้อมูลสำเร็จ",
              type: "success"
          }, function() {
              window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    // exit();
}else{
   echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';

    } //sweet alert
        
    } //row count
    
} //isset
?>