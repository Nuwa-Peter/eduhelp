<?php
function generate_edh_id($type, $gender = null) {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sequence_type = $type;
    if ($type === 'teacher' || $type === 'student') {
        $sequence_type .= '_' . $gender;
    }

    $stmt = $conn->prepare("SELECT last_id FROM id_sequences WHERE sequence_type = ?");
    $stmt->bind_param("s", $sequence_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $last_id = $row['last_id'];
    $stmt->close();

    $new_id = $last_id + 1;

    $stmt = $conn->prepare("UPDATE id_sequences SET last_id = ? WHERE sequence_type = ?");
    $stmt->bind_param("is", $new_id, $sequence_type);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    $prefix = '';
    switch ($type) {
        case 'school':
            $prefix = 'edh';
            break;
        case 'teacher':
            $prefix = 'edht' . ($gender === 'male' ? 'm' : 'f');
            break;
        case 'student':
            $prefix = 'edhs' . ($gender === 'male' ? 'm' : 'f');
            break;
    }

    return $prefix . str_pad($new_id, 5, '0', STR_PAD_LEFT);
}

function upload_logo($file, $edh_school_id) {
    $target_dir = "../uploads/logos/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $edh_school_id . '.' . $imageFileType;
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return 'uploads/logos/' . $edh_school_id . '.' . $imageFileType;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}
?>
