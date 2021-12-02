<?php
############################################
# Classe Image 0.0.2 Alpha                 #
############################################
# Criador: Felipe Lucio da Silva           #
# Data: 22/07/06                           #
# Email Contato: felipels[at]msn.com       #
#==========================================#
# Esta classe foi criada com o             #
# intuito de facilitar o redimensionamento #
# e outros processos como marca d'agua,    #
# e quem sabe, daqui algum tempo, ate      #
# alguns desenhos simples na imagens (!!)  #
#                                          #
# Ela está livre para o uso e melhoria,    #
# caso modifique, por favor, disponibilize #
# a modificação. E lembre-se de me avisar  #
# pelo email!                              #
############################################

defined("SSX") or die;

class SsxImage
{
    public $name;
    public $x;
    public $y;
    public $mime;
    public $path;
    public $resource;

    // Construtor, recebe argumento com o path/nome da img a ser aberta
    public function __construct($path)
    {
        if(is_file($path))
        {
            $temp       = @getimagesize($path);
            $this->mime = $temp['2'];
            $this->x    = $temp['0'];
            $this->y    = $temp['1'];
            
            // Separa o path do nome da imagem
            $this->path = explode('/',$path);
            $this->name = array_pop($this->path);
            $this->path = implode('/',$this->path);
            $this->path .= "/";
            // Abre o resource já na inicialização do Objeto
            $this->open();
        }

        /*
            Caso caminho seja uma url e não um arquivo
        */
        if (!filter_var($path, FILTER_VALIDATE_URL) === false) {
            $this->path_default = $path;
            $this->path = explode('/',$path);
            $this->name = array_pop($this->path);
            $this->path = implode('/',$this->path);
            $this->extension = explode('.', $this->name);
            $this->extension = array_pop($this->extension);
            $this->open($is_url=true);
        }else{
            return $this->path;
        }

    }

    // Abre o resource da imagem "dinamicamente" (ou quase isso) =P
    public function open($is_url=false)
    {
        if(is_file($this->path.$this->name))
        {
            switch($this->mime)
            {
                case 1:
                    $this->resource = imagecreatefromgif($this->path.$this->name);
                    break;
                case 2:
                    $this->resource = imagecreatefromjpeg($this->path.$this->name);
                    break;
                case 3:
                    $this->resource = imagecreatefrompng($this->path.$this->name);
                    break;
                case 6:
                    $this->resource = imagecreatefromwbmp($this->path.$this->name);
                    break;
                default:
                    $this->resource = false;
                    break;
            }
        }

        if($is_url){
            switch($this->extension)
            {
                case 'gif':
                    $this->resource = imagecreatefromgif($this->path_default);
                    break;
                case 'jpg':
                    $this->resource = imagecreatefromjpeg($this->path_default);
                    break;
                case 'png':
                    $this->resource = imagecreatefrompng($this->path_default);
                    break;
                case 'wbmp':
                    $this->resource = imagecreatefromwbmp($this->path_default);
                    break;
                default:
                    $this->resource = false;
                    break;
            }   
        }

    }

    // Metodo para "juntar" duas imagens, os argumentos sao
    // $sImg - outro objeto da classe SsxImage
    // $dX e $dY - posicao x e y onde a segunda imagem vai sobrepor a original
    // $alpha - transparencia: 0 - transparente, 100 simplesmente copia
    // $sX e $sY - Serve para pegar somente uma parteda img original
    // $sW e $sH - Altura e Largura do "box" de sobreposicao
    public function merge(SsxImage $sImg/*,$dX=0,$dY=0,$alpha=100,$sX=0,$sY=0,$sW=FALSE,$sH=FALSE*/,$copymerge=false)
    {
        /*if(!$sW)
        {
            $sW = $sImg->x;
        }

        if(!$sH)
        {
            $sH = $sImg->y;
        }*/

        imagealphablending($this->resource,TRUE);
        imagealphablending($sImg->resource,TRUE);
        imageSaveAlpha($this->resource, true);
        imageSaveAlpha($sImg->resource, true);
        if($copymerge == false){
            imagecopy( $this->resource,$sImg->resource, 0, 0, 0, 0, $this->x, $this->y );
        }else{
            imagecopymerge($this->resource,$sImg->resource,0, 0, 0, 0,$this->x, $this->y,100);
        }
        //imagealphablending($sImg->resource,FALSE);
    }

    // Metodo para Redimensionar a img, e so colocar o novo tamanho de x e y
    public function resize($newX,$newY)
    {
        if($this->resource)
        {
            $newImg = imagecreatetruecolor($newX,$newY);
            imagecopyresampled($newImg,$this->resource,0,0,0,0,$newX,$newY,$this->x,$this->y);
            $this->resource = $newImg;
            $this->x = $newX;
            $this->y = $newY;
        }
        else
        {
            return false;
        }
    }
    
    public function moveTo($x, $y)
    {
        if($this->resource)
        {
            $newImg = imagecreatetruecolor($this->x,$this->y);
            imagecopyresampled($newImg,$this->resource,$x,$y,0,0,$this->x,$this->y,$this->x,$this->y);
            $this->resource = $newImg;
            $this->x = $newX;
            $this->y = $newY;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Redimenciona a imagem sempre no centro
     * 
     * @param int $newX
     * @param int $nexY
     */
    public function fitCenter($newX, $newY, $padding_top=false, $padding_left=false,$transparente=false)
    {
        
        $prop_new = $newX / $newY;
        $prop_anterior = $this->x / $this->y;
        
         if($prop_new > $prop_anterior)
         {
             $newWidth = $newX;
             $newHeigth = $newWidth / $prop_anterior;
         }else
         {
             $newHeigth = $newY;
             $newWidth = $newHeigth * $prop_anterior;
         }
         
         if($padding_left === false)
            $padding_left = Math::Round(($newX/2) - ($newWidth/2));
            
         if($padding_top === false)
            $padding_top =  Math::Round(($newY/2) - ($newHeigth/2));
         
         
         $newImg = imagecreatetruecolor($newWidth,$newHeigth);
         if($transparente){
            imagealphablending($newImg, false );
            imagesavealpha( $newImg, true );
         }
         imagecopyresampled($newImg,$this->resource,0,0,0,0,$newWidth,$newHeigth,$this->x,$this->y);
         
         $newImgFinal = imagecreatetruecolor($newX,$newY);
         if($transparente){
            imagealphablending($newImgFinal, false );
            imagesavealpha( $newImgFinal, true );
         }
         imagecopyresampled($newImgFinal,$newImg,$padding_left,$padding_top,0,0,$newWidth,$newHeigth,$newWidth,$newHeigth);
         
         
         $this->resource = $newImgFinal;
         $this->x = $newX;
         $this->y = $newY;
         
         return array('top'=>$padding_top, 'left'=>$padding_left);
    }
    
    public function propWidth($newX)
    {
        $propHeight = $this->y * $newX / $this->x;
        $this->resize($newX, $propHeight);
    }

    // Metodo para salvar as alteracoes feitas na imagem, se não passar argumentos
    // ele simplesmente sobrepoe o arquivo original
    public function save($name='',$galeria_dia=null)
    {
        // Limpa a string
        $name = trim($name);
        // se nao foi passado parametro a classe pega os dados da imagem original
        if($name=='')
        {
            $name = $this->path.$this->name;
        }
        if($galeria_dia != null){    
            // $name = $this->path.$name;   
        }
        // Pega o formato de acordo com a extensao do nome passado como argumento
        $format = strtolower(substr($name,-3,3));
        switch($format)
        {
            case 'gif':
                imagegif($this->resource,$name,75);
                break;
            case 'peg':
            case 'jpg':
                imagejpeg($this->resource,$name,75);
                break;
            case 'png':
                imagepng($this->resource,$name);
                break;
            case 'bmp':
                imagewbmp($this->resource,$name,75);
                break;
            default:
                return false;
                break;
        }
    }

}

?>
