<?php 
 
// Courtesy of https://www.codexworld.com/upload-image-to-imgur-api-using-php/

// Client ID of Imgur App 
$IMGUR_CLIENT_ID = "de3510ce1fe86eb"; 
 
 
$statusMsg = $valErr = ''; 
$status = 'danger'; 
$imgurData = array(); 
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
     
    // Validate form input fields 
    if(empty($_FILES["image"]["name"])){ 
        $valErr .= 'Please select a file to upload.<br/>'; 
    } 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // Source image 
            $image_source = file_get_contents($_FILES['image']['tmp_name']); 
             
            // API post parameters 
            $postFields = array('image' => base64_encode($image_source)); 
             
            if(!empty($_POST['title'])){ 
                $postFields['title'] = $_POST['title']; 
            } 
             
            if(!empty($_POST['description'])){ 
                $postFields['description'] = $_POST['description']; 
            } 
             
            // Post image to Imgur via API 
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image'); 
            curl_setopt($ch, CURLOPT_POST, TRUE); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $IMGUR_CLIENT_ID)); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields); 
            $response = curl_exec($ch); 
            curl_close($ch); 
             
            // Decode API response to array 
            $responseArr = json_decode($response); 
             
            print '<pre>'; print_r($responseArr); print '</pre>'; 

            printf('<img height="180" src="%s" >', $responseArr->data->link);
            // Check image upload status 
            if(!empty($responseArr->data->link)){ 
                $imgurData = $responseArr; 
                 
                $status = 'success'; 
                $statusMsg = 'The image has been uploaded to Imgur successfully.'; 
            }else{ 
                $statusMsg = 'Image upload failed, please try again after some time.'; 
            } 
        }else{ 
            $statusMsg = 'Sorry, only an image file is allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
} 
 
?>