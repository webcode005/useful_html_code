<?php 
include "db.php";

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:*");
header("Access-Control-Allow-Methods:*");

 $method= $_SERVER['REQUEST_METHOD'];
// echo $method;
switch ($method) {
    case 'GET':
        
        $path = explode('/', $_SERVER['REQUEST_URI']);
        
        if (isset($path[3]) && is_numeric($path[3])) {
                $json_array = array();

                $product_id = $path[3];

                //echo "get product_ id..".$product_id;die;

                $single_product__sql = "SELECT * FROM tbl_product where id='$product_id' order by id desc";
                $result = $conn->query($single_product__sql);

                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    
                    $json_array[] = array("id" => $row["id"], "name" => $row["pname"],"pimage" => $row["p_image"],"price" => $row["price"] ,"status" => $row["status"]);
                
                }
                echo json_encode($json_array,true); 
                return;
                } else {
                    echo json_encode(["result"=>"Please check table"]);
                    
                    return;
                }






        }

        
        
        else 
        {
           
                $allproduct__sql = "SELECT * FROM tbl_product order by id desc";
                $result = $conn->query($allproduct__sql);

                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    
                    $json_array[] = array("id" => $row["id"], "name" => $row["pname"],"price" => $row["price"] ,"pimage" => $row["p_image"] ,"status" => $row["status"]);
                
                }
                echo json_encode($json_array,true); 
                return;
                } else {
                    echo json_encode(["result"=>"Please check table"]);
                    
                    return;
                }

        }
        break;

    case "POST":
        $product_postData = json_decode(file_get_contents("php://input")) ;
        
        // echo"success data"; product_image

        // print_r($product_postData);

        $product_name = $product_postData->product_name;
        $price    = $product_postData->price;
        $p_image    = $product_postData->pimage;

        $status = $product_postData->status;

        if (!empty($product_name) && !empty($price) && !empty($p_image) && !empty($status)) 
        {
            
        

                    $result = mysqli_query($conn, "INSERT INTO tbl_product (pname,price,p_image,status) VALUES ('$product_name','$price','$p_image','$status')");

                    if ($result) {
                        echo json_encode(["success"=>"product_ Added Successfully"]);
                        
                        return;
                    }
                    else
                    {
                        echo json_encode(["success"=>"Failed to add product_ Details"]);
                        
                        return;
                    }

            
        } else {
            echo json_encode(["success"=>"Please fill all details"]);
                        
                        return;
        }
        
        
        break;
    
    default:
        echo "no data";
        break;
}






?>