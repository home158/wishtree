<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**

TinyMCE Inclusion Class
@package        CodeIgniter
@subpackage    Libraries
@category    WYSIWUG
@author        WackyWebs.net - Tom Glover
@link        http://codeigniter.com/user_guide/libraries/zip.html
*/

class Tinymce {
    /*

    Create Head Code - this converts $mode value to TinyMCE editors
    $Mode is the mode TinyMCE runs in - Please view TinyMCE manual for more detail
    $Theme is this style of running, eg advance or basic, defult advance
    $ToolLoc is the vertical location of the toolbar, Defult = 'top'
    $ToolAligh is the Horizontal Location of the toolbar, DeFult = 'left'
    $Resizeabe - Can the Client resize it on there web page.
    use in controllers like so:
    $data ['head'] = $this->tinymce->createhead('mode','theme','toolbar loc','toolbar align','resizable')
    */
    function createhead($Mode = 'textareas', $Theme = 'advanced', $ToolLoc = 'Top', $ToolAlign = 'left', $Resizable = FALSE)
    {
        $CI =& get_instance();
        
        $init = array
                (
                    'selector' => "textarea",
                    'theme' => "modern",
                    'language' => 'zh_TW',
                    'width'=> '100%',
                    'height'=> '100%',
                    'toolbar1' => "responsivefilemanager insertfile undo redo | styleselect  | fontselect | fontsizeselect 
                    | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor",
                    'plugins' => array
                    (
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "paste textcolor colorpicker textpattern autoresize"
                    ),
                    "fontsize_formats" => "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                    'image_advtab' => true,
   
                    'external_filemanager_path'=>"/filemanager/",
                    'filemanager_title'=>"Responsive Filemanager" ,
                    'external_plugins'=> array( 
                            "filemanager" => "/filemanager/plugin.min.js"
                    ),
                    'setup' => "function(ed) {ed.onInit.add(function(ed) {ed.execCommand(\"fontName\", false, \"Arial\");ed.execCommand(\"fontSize\", false, \"2\");});}"
                );
        return "tinyMCE.init(" . json_encode($init) . ");";
    }
 
    
    
    
    /*

    Create Text Box
    Does not have to use variable in creation as can just return textarea, without
    $FullCode - True = Outputs full text area codein form tag! False = just the Tag no
    Form Wrap - Defult = False
    $Methord - Post or Get - Required if FC=True - String
    $Action - Controller to Call on Submission - Required if FC=True - String - Can use
    URL Helper
    $data ['head'] = $this->tinymce->createhead('Fullcode','Action','Methord')
    */
    function textarea($FullCode = FALSE, $Action = '', $Buttons = null ,$Methord = "POST")
    {
        if ($FullCode === TRUE){
            $mce = "<form action=\"$Action\" method=\"$Methord\">";
            $mce .= "<textarea name=\"tinymce\" ></textarea>";
            $mce .= "<br/>";
            $mce .= "<div style=\"text-align:right;\">";
            $mce .= $this->created_buttons($Buttons);
            $mce .= "</form>";
            $mce .= "<div/>";
            return $mce ;// Outputs to view file - String
        }else{
            $mce = "<textarea name=\"TinyMCE\" cols=\"30\" rows=\"100\"></textarea>";
            return $mce ;// Outputs to view file - String
        }
    }
    
    

    function created_buttons($Buttons)
    {
        $CI =& get_instance();
        $CI->load->helper('html');

        $html = "";
        if($Buttons!= null){
            foreach ($Buttons as $element ) {
                $html .= "<input ";
                foreach ($element as $key => $value) {
                    $html .= $key.'="'.$value.'"';
                }
                
                //'LAST ELEMENT!'
                if ($element !== end($Buttons)){
                    $html .= "/>";
                    $html .= nbs(3);
                }
            }
            return $html;
            
        }else{
        
            //Default buttons
            $html .= "<input name=\"mce_submit\" type=\"submit\" class=\"btn-relax\" value=\"&nbsp;&nbsp;送出&nbsp;&nbsp;\">";
            $html .= nbs(1);
            $html .= "<input name=\"mce_reset\" type=\"reset\" class=\"btn-relax\" value=\"&nbsp;&nbsp;重設&nbsp;&nbsp;\">";
            $html .= nbs(1);
            $html .= "<input name=\"mce_cancel\" type=\"button\" class=\"btn-relax\" value=\"&nbsp;&nbsp;取消&nbsp;&nbsp;\">";
            return $html;
            
        }
        
    }
}



/* End of file Tinymce.php */
/* Location: ./aplication/libraries/Tinymce.php */