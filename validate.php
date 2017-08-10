<?php

class Validator{
/*
 * checking inputs
 * @param array
 * @param array
 * @return String
 * */
    public static function Check($input,$rules)
    {
        $input= Validator::html_special_chars($input);
        $input= Validator::mysqli_escape($input);

        $error=array();
        $success=array();

        foreach($input as $input_name => $input_value)
        {
            foreach($rules as $rule_name => $rule_value)
            {
                if($input_name==$rule_name)
                {
                    $rule_array = explode("|",$rule_value);
                    foreach ($rule_array as $key=>$value)
                    {
                        $function=$value;
                        if(preg_match("/min/",$function) || preg_match("/max/",$function) || preg_match("/custom/",$function))
                        {
                             $function = explode(":",$function);
                             $func_name=$function[0];
                             $limit = $function[1];
                             $result= Validator::$func_name($input_name,$input_value,$limit);
                        }else
                            {
                            $result = Validator::$value($input_name, $input_value);
                            }

                        if($result !="success")
                        {
                            if(!array_key_exists($input_name,$error)){
                            $error[$input_name]=$result;

                            }
                        }else{
                            array_push($success,$result);

                        }
                    }
                }
            }
        }
        if(count($error)==0){
            $success="True";
            $error = "null";
        }else{
            $success = "false";
        }
        return array("inputs"=>$input,"sucess"=>$success,"error_msg"=>$error);
    }
    /* checks required
     * @param string
     * @param string
     * @return string  */
    public static function required($key,$data){
        if(empty($data)){
            return ucwords($key." does not empty");
        }else{
            return "success";
        }
    }
    /* checks Int
     * @param string
     * @param string
     * @return string  */
    public static function numeric($key,$data){
        if(!is_int($data)){
            return ucwords($key." must be Numeric");
        }else{
            return "success";
        }
    }
    /*checks Strings
     * @param string
     * @param string
     * @return string  */
    public static function alpha($key,$data){
        if(!preg_match("/^[a-zA-Z]*$/",$data)){
            return ucwords($key." Must be Alphabets");
        }else{
            return "success";
        }
    }
    /*checks Minimum Value
     * @param string
     * @param string
     * @param integer
     * @return string  */
    public static function min($key,$data,$limit){

        if(strlen($data)<$limit){
            return ucwords($key." Must be greater than ".$limit);
        }else{
            return "success";
        }
    }
    /*checks Maximum Value
     * @param string
     * @param string
     * @param integer
     * @return string  */
    public static function max($key,$data,$limit){

        if(strlen($data)>$limit){
            return ucwords($key." Must be less than ".$limit);
        }else{
            return "success";
        }
    }
    /*checks Email contains @ and dot(.) position at 2 to 3
     * @param string
     * @param string
     * @return string  */
    public static function email($key,$data){

        if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$data)){
            return ucwords($key." is not correct");
        }else{
            return "success";
        }
    }
    /*checks UpperCase
     * @param string
     * @param string
     * @return string  */
    public static function upper($key,$data){

        if(!preg_match("/^[A-Z]*$/",$data)){
            return ucwords($key." is must contain only upper character");
        }else{
            return "success";
        }
    }
    /*checks LowerCase
   * @param string
   * @param string
   * @return string  */
    public static function lower($key,$data){

        if(!preg_match("/^[a-z]*$/",$data)){
            return ucwords($key." is must contain only lower character");
        }else{
            return "success";
        }
    }
    /*checks Phone_Number is length 10 to 13
   * @param string
   * @param string
   * @return string  */
    public static function phonenumber($key,$data){

        if(!preg_match("/^[+]?[0-9]{10,13}$/",$data)){
            return ucwords($key." is must contain only valid phone_numbers");
        }else{
            return "success";
        }
    }
    /*checks Password contains Atleast one upper,lower,number and special character
   * @param string
   * @param string
   * @return string  */
    public static function password($key,$data){

        if(!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*(){};:<>,.?/)[0-9A-Za-z!@#$%]{8,12}$/",$data)){
            return ucwords($key." is must contains 8characters and uppercase,lowercase and special_characters");
        }else{
            return "success";
        }
    }
  /* checks alphanumeric it contains only letters and numbers
  * @param string
  * @param string
  * @return string  */
    public static function alphanumeric($key,$data){
        if(!preg_match("/^[a-zA-Z0-9]*$/",$data)){
            return ucwords($key." is must contains only alphabets and numbers");
        }else{
            return "success";
        }
    }
    /*checks Custom function
   * @param string
   * @param string
   * @return string  */
    public static function custom($key,$data,$limit){
        if(!preg_match($limit,$data)){
            return ucwords($key." is Error");
        }else{
            return "success";
        }
    }
    /*checks html_special_chars
   * @param array
   * @return array  */
    public static function html_special_chars($input){
        $array=array();
       foreach($input as $key => $value) {
           if(!is_int($value)) {
               $value = htmlspecialchars($value);
               $temp = array($key=>$value);
               $array = $array + $temp;
           }else{
               $temp = array($key=>$value);
               $array = $array + $temp;
           }
       }return $array;

    }
    /*checks mysqli_real_escape_strings
   * @param array
   * @return array  */
    public static function mysqli_escape($input)
    {
        $conn = mysqli_connect("localhost","root","");
        $array = array();
        foreach ($input as $key => $value) {
            if (!is_int($value)) {
                $value = mysqli_real_escape_string($conn,$value);
                $temp = array($key => $value);
                $array = $array + $temp;
            } else {
                $temp = array($key => $value);
                $array = $array + $temp;
            }
        }
        return $array;
    }

}
$value= array("name"=>"ganesh","age"=>22,"email"=>"Ganesh@gmail.com");
$rule = array("name"=>"required|alpha","age"=>"required|numeric","email"=>"required|email");
$result = Validator::Check($value,$rule);
echo"<pre>";
print_r($result);


