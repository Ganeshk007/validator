**PHP Validator**

## Options(Functions)
 * Required
 * Numeric
 * Alpha
 * AlphaNumeric
 * Min
 * Max
 * Lower
 * Upper
 * Email
 * Password
 * Phonenumber
 * Custom
  
## Example
  Sample Input :
          `$value= array("name"=>"ganesh","age"=>22,"email"=>"Ganesh@gmail.com");`
          `$rule = array("name"=>"required|alpha","age"=>"required|numeric","email"=>"required|email");`
  
  Sample Output :
         `Array
           (
               [inputs] => Array
                 (
                   [name] => ganesh
                   [age] => 22
                   [email] => Ganesh@gmail.com
                 )

               [sucess] => True
               [error_msg] => null
           )
