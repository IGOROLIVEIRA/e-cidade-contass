<?php

/*******************************************************************************
 * FPDF                                                                         *
 *                                                                              *
 * Version: 1.7                                                                 *
 * Date:    2011-06-18                                                          *
 * Author:  Olivier PLATHEY                                                     *
 *******************************************************************************/

define('FPDF_VERSION', '1.7');

class FPDF
{
    var $page;               // current page number
    var $n;                  // current object number
    var $offsets;            // array of object offsets
    var $buffer;             // buffer holding in-memory PDF
    var $pages;              // array containing pages
    var $state;              // current document state
    var $compress;           // compression flag
    var $k;                  // scale factor (number of points in user unit)
    var $DefOrientation;     // default orientation
    var $CurOrientation;     // current orientation
    var $StdPageSizes;       // standard page sizes
    var $DefPageSize;        // default page size
    var $CurPageSize;        // current page size
    var $PageSizes;          // used for pages with non default sizes or orientations
    var $wPt, $hPt;          // dimensions of current page in points
    var $w, $h;              // dimensions of current page in user unit
    var $lMargin;            // left margin
    var $tMargin;            // top margin
    var $rMargin;            // right margin
    var $bMargin;            // page break margin
    var $cMargin;            // cell margin
    var $x, $y;              // current position in user unit
    var $lasth;              // height of last printed cell
    var $LineWidth;          // line width in user unit
    var $fontpath;           // path containing fonts
    var $CoreFonts;          // array of core font names
    var $fonts;              // array of used fonts
    var $FontFiles;          // array of font files
    var $diffs;              // array of encoding differences
    var $FontFamily;         // current font family
    var $FontStyle;          // current font style
    var $underline;          // underlining flag
    var $CurrentFont;        // current font info
    var $FontSizePt;         // current font size in points
    var $FontSize;           // current font size in user unit
    var $DrawColor;          // commands for drawing color
    var $FillColor;          // commands for filling color
    var $TextColor;          // commands for text color
    var $ColorFlag;          // indicates whether fill and text colors are different
    var $ws;                 // word spacing
    var $images;             // array of used images
    var $PageLinks;          // array of links in pages
    var $links;              // array of internal links
    var $AutoPageBreak;      // automatic page breaking
    var $PageBreakTrigger;   // threshold used to trigger page breaks
    var $InHeader;           // flag set when processing header
    var $InFooter;           // flag set when processing footer
    var $ZoomMode;           // zoom display mode
    var $LayoutMode;         // layout display mode
    var $title;              // title
    var $subject;            // subject
    var $author;             // author
    var $keywords;           // keywords
    var $creator;            // creator
    var $AliasNbPages;       // alias for total number of pages
    var $PDFVersion;         // PDF version number

    /*******************************************************************************
     *                                                                              *
     *                               Public methods                                 *
     *                                                                              *
     *******************************************************************************/
    function FPDF($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        // Some checks
        $this->_dochecks();
        // Initialization of properties
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = array();
        $this->PageSizes = array();
        $this->state = 0;
        $this->fonts = array();
        $this->FontFiles = array();
        $this->diffs = array();
        $this->images = array();
        $this->links = array();
        $this->InHeader = false;
        $this->InFooter = false;
        $this->lasth = 0;
        $this->FontFamily = '';
        $this->FontStyle = '';
        $this->FontSizePt = 12;
        $this->underline = false;
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
        $this->ws = 0;
        // Font path
        if (defined('FPDF_FONTPATH')) {
            $this->fontpath = FPDF_FONTPATH;
            if (substr($this->fontpath, -1) != '/' && substr($this->fontpath, -1) != '\\')
                $this->fontpath .= '/';
        } elseif (is_dir(dirname(__FILE__) . '/font'))
            $this->fontpath = dirname(__FILE__) . '/font/';
        else
            $this->fontpath = '';
        // Core fonts
        $this->CoreFonts = array('courier', 'helvetica', 'times', 'symbol', 'zapfdingbats');
        // Scale factor
        if ($unit == 'pt')
            $this->k = 1;
        elseif ($unit == 'mm')
            $this->k = 72 / 25.4;
        elseif ($unit == 'cm')
            $this->k = 72 / 2.54;
        elseif ($unit == 'in')
            $this->k = 72;
        else
            $this->Error('Incorrect unit: ' . $unit);
        // Page sizes
        $this->StdPageSizes = array(
            'a3' => array(841.89, 1190.55), 'a4' => array(595.28, 841.89), 'a5' => array(420.94, 595.28),
            'letter' => array(612, 792), 'legal' => array(612, 1008)
        );
        $size = $this->_getpagesize($size);
        $this->DefPageSize = $size;
        $this->CurPageSize = $size;
        // Page orientation
        $orientation = strtolower($orientation);
        if ($orientation == 'p' || $orientation == 'portrait') {
            $this->DefOrientation = 'P';
            $this->w = $size[0];
            $this->h = $size[1];
        } elseif ($orientation == 'l' || $orientation == 'landscape') {
            $this->DefOrientation = 'L';
            $this->w = $size[1];
            $this->h = $size[0];
        } else
            $this->Error('Incorrect orientation: ' . $orientation);
        $this->CurOrientation = $this->DefOrientation;
        $this->wPt = $this->w * $this->k;
        $this->hPt = $this->h * $this->k;
        // Page margins (1 cm)
        $margin = 28.35 / $this->k;
        $this->SetMargins($margin, $margin);
        // Interior cell margin (1 mm)
        $this->cMargin = $margin / 10;
        // Line width (0.2 mm)
        $this->LineWidth = .567 / $this->k;
        // Automatic page break
        $this->SetAutoPageBreak(true, 2 * $margin);
        // Default display mode
        $this->SetDisplayMode('default');
        // Enable compression
        $this->SetCompression(true);
        // Set default PDF version number
        $this->PDFVersion = '1.3';
    }

    function SetMargins($left, $top, $right = null)
    {
        // Set left, top and right margins
        $this->lMargin = $left;
        $this->tMargin = $top;
        if ($right === null)
            $right = $left;
        $this->rMargin = $right;
    }

    function SetLeftMargin($margin)
    {
        // Set left margin
        $this->lMargin = $margin;
        if ($this->page > 0 && $this->x < $margin)
            $this->x = $margin;
    }

    function GetLeftMargin() {
      return $this->lMargin;
    }

    function SetTopMargin($margin)
    {
        // Set top margin
        $this->tMargin = $margin;
    }

    function SetRightMargin($margin)
    {
        // Set right margin
        $this->rMargin = $margin;
    }
    
    function GetRightMargin() {
        return $this->rMargin;
      }      

    function SetAutoPageBreak($auto, $margin = 0)
    {
        // Set auto page break mode and triggering margin
        $this->AutoPageBreak = $auto;
        $this->bMargin = $margin;
        $this->PageBreakTrigger = $this->h - $margin;
    }

    function SetDisplayMode($zoom, $layout = 'default')
    {
        // Set display mode in viewer
        if ($zoom == 'fullpage' || $zoom == 'fullwidth' || $zoom == 'real' || $zoom == 'default' || !is_string($zoom))
            $this->ZoomMode = $zoom;
        else
            $this->Error('Incorrect zoom display mode: ' . $zoom);
        if ($layout == 'single' || $layout == 'continuous' || $layout == 'two' || $layout == 'default')
            $this->LayoutMode = $layout;
        else
            $this->Error('Incorrect layout display mode: ' . $layout);
    }

    function SetCompression($compress)
    {
        // Set page compression
        if (function_exists('gzcompress'))
            $this->compress = $compress;
        else
            $this->compress = false;
    }

    function SetTitle($title, $isUTF8 = false)
    {
        // Title of document
        if ($isUTF8)
            $title = $this->_UTF8toUTF16($title);
        $this->title = $title;
    }

    function SetSubject($subject, $isUTF8 = false)
    {
        // Subject of document
        if ($isUTF8)
            $subject = $this->_UTF8toUTF16($subject);
        $this->subject = $subject;
    }

    function SetAuthor($author, $isUTF8 = false)
    {
        // Author of document
        if ($isUTF8)
            $author = $this->_UTF8toUTF16($author);
        $this->author = $author;
    }

    function SetKeywords($keywords, $isUTF8 = false)
    {
        // Keywords of document
        if ($isUTF8)
            $keywords = $this->_UTF8toUTF16($keywords);
        $this->keywords = $keywords;
    }

    function SetCreator($creator, $isUTF8 = false)
    {
        // Creator of document
        if ($isUTF8)
            $creator = $this->_UTF8toUTF16($creator);
        $this->creator = $creator;
    }

    function AliasNbPages($alias = '{nb}')
    {
        // Define an alias for total number of pages
        $this->AliasNbPages = $alias;
    }

    function Error($msg)
    {
        // Fatal error
        die('<b>FPDF error:</b> ' . $msg);
    }

    function Open()
    {
        // Begin document
        $this->state = 1;
    }

    function Close()
    {
        // Terminate document
        if ($this->state == 3)
            return;
        if ($this->page == 0)
            $this->AddPage();
        // Page footer
        $this->InFooter = true;
        $this->Footer();
        $this->InFooter = false;
        // Close page
        $this->_endpage();
        // Close document
        $this->_enddoc();
    }

    function AddPage($orientation = '', $size = '')
    {
        // Start a new page
        if ($this->state == 0)
            $this->Open();

        $family = $this->FontFamily;
        $style = $this->FontStyle . ($this->underline ? 'U' : '');
        $fontsize = $this->FontSizePt;
        $lw = $this->LineWidth;
        $dc = $this->DrawColor;
        $fc = $this->FillColor;
        $tc = $this->TextColor;
        $cf = $this->ColorFlag;

        if ($this->page > 0) {
            // Page footer
            $this->InFooter = true;
            $this->Footer();
            $this->InFooter = false;
            // Close page
            $this->_endpage();
        }
        // Start new page
        $this->_beginpage($orientation, $size);
        // Set line cap style to square
        $this->_out('2 J');
        // Set line width
        $this->LineWidth = $lw;
        $this->_out(sprintf('%.2F w', $lw * $this->k));
        // Set font
        if ($family)
            $this->SetFont($family, $style, $fontsize);
        // Set colors
        $this->DrawColor = $dc;
        if ($dc != '0 G')
            $this->_out($dc);
        $this->FillColor = $fc;
        if ($fc != '0 g')
            $this->_out($fc);
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
        // Page header
        $this->InHeader = true;
        $this->Header();
        $this->InHeader = false;

        // Restore line width
        if ($this->LineWidth != $lw) {
            $this->LineWidth = $lw;
            $this->_out(sprintf('%.2F w', $lw * $this->k));
        }
        // Restore font
        if ($family)
            $this->SetFont($family, $style, $fontsize);
        // Restore colors
        if ($this->DrawColor != $dc) {
            $this->DrawColor = $dc;
            $this->_out($dc);
        }
        if ($this->FillColor != $fc) {
            $this->FillColor = $fc;
            $this->_out($fc);
        }
        $this->TextColor = $tc;
        $this->ColorFlag = $cf;
    }

    function Header()
    {
        // To be implemented in your own inherited class
    }

    function Footer()
    {
        // To be implemented in your own inherited class
    }

    function PageNo()
    {
        // Get current page number
        return $this->page;
    }

    function SetDrawColor($r, $g = null, $b = null)
    {
        // Set color for all stroking operations
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->DrawColor = sprintf('%.3F G', $r / 255);
        else
            $this->DrawColor = sprintf('%.3F %.3F %.3F RG', $r / 255, $g / 255, $b / 255);
        if ($this->page > 0)
            $this->_out($this->DrawColor);
    }

    function SetFillColor($r, $g = null, $b = null)
    {
        // Set color for all filling operations
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->FillColor = sprintf('%.3F g', $r / 255);
        else
            $this->FillColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
        if ($this->page > 0)
            $this->_out($this->FillColor);
    }

    function SetTextColor($r, $g = null, $b = null)
    {
        // Set color for text
        if (($r == 0 && $g == 0 && $b == 0) || $g === null)
            $this->TextColor = sprintf('%.3F g', $r / 255);
        else
            $this->TextColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }

    function GetStringWidth($s)
    {
        // Get width of a string in the current font
        $s = (string)$s;
        $cw = &$this->CurrentFont['cw'];
        $w = 0;
        $l = strlen($s);
        for ($i = 0; $i < $l; $i++)
            $w += $cw[$s[$i]];
        return $w * $this->FontSize / 1000;
    }

    function SetLineWidth($width)
    {
        // Set line width
        $this->LineWidth = $width;
        if ($this->page > 0)
            $this->_out(sprintf('%.2F w', $width * $this->k));
    }

    function Line($x1, $y1, $x2, $y2)
    {
        // Draw a line
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F l S', $x1 * $this->k, ($this->h - $y1) * $this->k, $x2 * $this->k, ($this->h - $y2) * $this->k));
    }

    function Rect($x, $y, $w, $h, $style = '')
    {
        // Draw a rectangle
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $this->_out(sprintf('%.2F %.2F %.2F %.2F re %s', $x * $this->k, ($this->h - $y) * $this->k, $w * $this->k, -$h * $this->k, $op));
    }

    function AddFont($family, $style = '', $file = '')
    {
        // Add a TrueType, OpenType or Type1 font
        $family = strtolower($family);
        if ($file == '')
            $file = str_replace(' ', '', $family) . strtolower($style) . '.php';
        $style = strtoupper($style);
        if ($style == 'IB')
            $style = 'BI';
        $fontkey = $family . $style;
        if (isset($this->fonts[$fontkey]))
            return;
        $info = $this->_loadfont($file);
        $info['i'] = count($this->fonts) + 1;
        if (!empty($info['diff'])) {
            // Search existing encodings
            $n = array_search($info['diff'], $this->diffs);
            if (!$n) {
                $n = count($this->diffs) + 1;
                $this->diffs[$n] = $info['diff'];
            }
            $info['diffn'] = $n;
        }
        if (!empty($info['file'])) {
            // Embedded font
            if ($info['type'] == 'TrueType')
                $this->FontFiles[$info['file']] = array('length1' => $info['originalsize']);
            else
                $this->FontFiles[$info['file']] = array('length1' => $info['size1'], 'length2' => $info['size2']);
        }
        $this->fonts[$fontkey] = $info;
    }

    function SetFont($family, $style = '', $size = 0)
    {
        // Select a font; size given in points
        if ($family == '')
            $family = $this->FontFamily;
        else
            $family = strtolower($family);
        $style = strtoupper($style);
        if (strpos($style, 'U') !== false) {
            $this->underline = true;
            $style = str_replace('U', '', $style);
        } else
            $this->underline = false;
        if ($style == 'IB')
            $style = 'BI';
        if ($size == 0)
            $size = $this->FontSizePt;
        // Test if font is already selected
        if ($this->FontFamily == $family && $this->FontStyle == $style && $this->FontSizePt == $size)
            return;
        // Test if font is already loaded
        $fontkey = $family . $style;
        if (!isset($this->fonts[$fontkey])) {
            // Test if one of the core fonts
            if ($family == 'arial')
                $family = 'helvetica';
            if (in_array($family, $this->CoreFonts)) {
                if ($family == 'symbol' || $family == 'zapfdingbats')
                    $style = '';
                $fontkey = $family . $style;
                if (!isset($this->fonts[$fontkey])) {
                    $this->AddFont($family, $style);
                }
            } else
                $this->Error('Undefined font: ' . $family . ' ' . $style);
        }
        // Select it
        $this->FontFamily = $family;
        $this->FontStyle = $style;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        $this->CurrentFont = &$this->fonts[$fontkey];
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

    function SetFontSize($size)
    {
        // Set font size in points
        if ($this->FontSizePt == $size)
            return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

    function AddLink()
    {
        // Create a new internal link
        $n = count($this->links) + 1;
        $this->links[$n] = array(0, 0);
        return $n;
    }

    function SetLink($link, $y = 0, $page = -1)
    {
        // Set destination of internal link
        if ($y == -1)
            $y = $this->y;
        if ($page == -1)
            $page = $this->page;
        $this->links[$link] = array($page, $y);
    }

    function Link($x, $y, $w, $h, $link)
    {
        // Put a link on the page
        $this->PageLinks[$this->page][] = array($x * $this->k, $this->hPt - $y * $this->k, $w * $this->k, $h * $this->k, $link);
    }

    function Text($x, $y, $txt)
    {
        // Output a string
        $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->underline && $txt != '')
            $s .= ' ' . $this->_dounderline($x, $y, $txt);
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    function AcceptPageBreak()
    {
        // Accept automatic page break or not
        return $this->AutoPageBreak;
    }

    function Cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='',$preenc='')
//#00#//cell
//#10#//Imprime uma célula (área retangular) com bordas opcionais, cor de fundo e  texto. O  canto  superior-esquerdo da
//#10#//célula corresponde à posição atual. O texto pode ser alinhado ou  centralizado.  Depois de  chamada,   a posição
//#10#//atual se move para a direita ou para a linha seguinte. É possível pôr um link no texto.
//#10#//Se a quebra de página automática está habilitada e a pilha for além do limite,  uma  quebra  de  página é  feita
//#10#//antes da impressão.
//#15#//cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
//#20#//w            : Largura da célula. Se 0, a célula se extende até a margem direita.
//#20#//h            : Altura da célula. Valor padrão: 0.
//#20#//txt          : Texto a ser impresso. Valor padrão: texto vazio.
//#20#//border       : Indica se as bordas devem ser desenhadas em volta da célula. O valor deve ser um número:
//#20#//                  - 0: sem borda
//#20#//                  - 1: com borda
//#20#//         ou um texto contendo alguns ou todos os seguintes caracteres (em qualquer ordem):
//#20#//            - L: esquerda
//#20#//      - T: acima
//#20#//            - R: direita
//#20#//      - B: abaixo
//#20#//               Valor padrão: 0.
//#20#//ln           : Indica onde a posição corrente deve ficar depois que a função for chamada. Os  valores  possíveis
//#20#//               são:
//#20#//                  - 0: a direita
//#20#//                  - 1: no início da próxima linha
//#20#//      - 2: abaixo
//#20#//               Usar o valor 1 é equivalente a usar 0 e chamar a função Ln() logo após. Valor padrão: 0.
//#20#//align        : Permite centralizar ou alinhar o texto. Os valores possíveis são:
//#20#//                  - L ou um texto vazio: alinhado à esquerda (valor padrão)
//#20#//            - C: centralizado
//#20#//      - R: alinhado à direita
//#20#//fill         : Indica se o fundo da célula deve ser preenchido (1) ou transparente (0). Valor padrão: 0.
//#20#//link         : URL ou identificador retornado por |addlink|.
//#20#//preenc       : indica se a célula terá preenchimento a esquerda.
//#20#//         Ex.: $pdf->Cell(20,10,'Title',1,1,'C','','.')
//#20#//               preenche com (.) a direita do 'Title' até alcançar o tamanho da célula (20).
//#99#//Exemplo:
//#99#//  - Escolhe a fonte
//#99#//      $pdf->SetFont('Arial','B',16);
//#99#//  - Move para 8 cm a direita
//#99#//      $pdf->Cell(80);
//#99#//  - Texto centralizado em uma célula de 20*10 mm com borda e quebra de linha
//#99#//  -   $pdf->Cell(20,10,'Title',1,1,'C');
{
  //Output a cell
  $k=$this->k;
  if($this->y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak())
  {
    $x=$this->x;
    $ws=$this->ws;
    if($ws>0)
    {
      $this->ws=0;
      $this->_out('0 Tw');
    }
    $this->AddPage($this->CurOrientation);
    $this->x=$x;
    if($ws>0)
    {
      $this->ws=$ws;
      $this->_out(sprintf('%.3f Tw',$ws*$k));
    }
  }
  if($w==0)
    $w=$this->w-$this->rMargin-$this->x;
  $s='';
  if($fill==1 or $border==1)
  {
    if($fill==1)
      $op=($border==1) ? 'B' : 'f';
    else
      $op='S';
    $s=sprintf('%.2f %.2f %.2f %.2f re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
  }
  if(is_string($border))
  {
    $x=$this->x;
    $y=$this->y;
    if(is_int(strpos($border,'L')))
      $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
    if(is_int(strpos($border,'T')))
      $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
    if(is_int(strpos($border,'R')))
      $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
    if(is_int(strpos($border,'B')))
      $s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
  }
  if($txt!='')
  {
    if($align=='R')
      $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
    elseif($align=='C')
      $dx=($w-$this->GetStringWidth($txt))/2;
    else
      $dx=$this->cMargin;
    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
    $xdots='';
                if($preenc != ''){

                   $ww    = $this->GetStringWidth($txt);
                   if ($ww < $w ){
                       $quant   = ($w-$ww)/$this->GetStringWidth($preenc);
                       $xdots = str_repeat($preenc,$quant);
                   }else{
                       $xdots = '';
                   }

    }
    $txt = $txt.$xdots;

    if($this->ColorFlag)
      $s.='q '.$this->TextColor.' ';
    $s.=sprintf('BT %.2f %.2f Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt);
    if($this->underline)
      $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
    if($this->ColorFlag)
      $s.=' Q';
    if($link)
      $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
  }
  if($s)
    $this->_out($s);
  $this->lasth=$h;
  if($ln>0)
  {
    //Go to next line
    $this->y+=$h;
    if($ln==1)
      $this->x=$this->lMargin;
  }
  else
    $this->x+=$w;
}

    function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
    {
        // Output text with automatic or explicit line breaks
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $b = 0;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (strpos($border, 'L') !== false)
                    $b2 .= 'L';
                if (strpos($border, 'R') !== false)
                    $b2 .= 'R';
                $b = (strpos($border, 'T') !== false) ? $b2 . 'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
            } else
                $i++;
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if ($border && strpos($border, 'B') !== false)
            $b .= 'B';
        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        $this->x = $this->lMargin;
    }

    function Write($h, $txt, $link = '')
    {
        // Output text in flowing mode
        $cw = &$this->CurrentFont['cw'];
        $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                if ($nl == 1) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($this->x > $this->lMargin) {
                        // Move to next line
                        $this->x = $this->lMargin;
                        $this->y += $h;
                        $w = $this->w - $this->rMargin - $this->x;
                        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                        $i++;
                        $nl++;
                        continue;
                    }
                    if ($i == $j)
                        $i++;
                    $this->Cell($w, $h, substr($s, $j, $i - $j), 0, 2, '', 0, $link);
                } else {
                    $this->Cell($w, $h, substr($s, $j, $sep - $j), 0, 2, '', 0, $link);
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                if ($nl == 1) {
                    $this->x = $this->lMargin;
                    $w = $this->w - $this->rMargin - $this->x;
                    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
                }
                $nl++;
            } else
                $i++;
        }
        // Last chunk
        if ($i != $j)
            $this->Cell($l / 1000 * $this->FontSize, $h, substr($s, $j), 0, 0, '', 0, $link);
    }

    function Ln($h = null)
    {
        // Line feed; default value is last cell height
        $this->x = $this->lMargin;
        if ($h === null)
            $this->y += $this->lasth;
        else
            $this->y += $h;
    }

    function Image($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '')
    {
        // Put an image on the page
        if (!isset($this->images[$file])) {
            // First use of this image, get info
            if ($type == '') {
                $pos = strrpos($file, '.');
                if (!$pos)
                    $this->Error('Image file has no extension and no type was specified: ' . $file);
                $type = substr($file, $pos + 1);
            }
            $type = strtolower($type);
            if ($type == 'jpeg')
                $type = 'jpg';
            $mtd = '_parse' . $type;
            if (!method_exists($this, $mtd))
                $this->Error('Unsupported image type: ' . $type);
            $info = $this->$mtd($file);
            $info['i'] = count($this->images) + 1;
            $this->images[$file] = $info;
        } else
            $info = $this->images[$file];

        // Automatic width and height calculation if needed
        if ($w == 0 && $h == 0) {
            // Put image at 96 dpi
            $w = -96;
            $h = -96;
        }
        if ($w < 0)
            $w = -$info['w'] * 72 / $w / $this->k;
        if ($h < 0)
            $h = -$info['h'] * 72 / $h / $this->k;
        if ($w == 0)
            $w = $h * $info['w'] / $info['h'];
        if ($h == 0)
            $h = $w * $info['h'] / $info['w'];

        // Flowing mode
        if ($y === null) {
            if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
                // Automatic page break
                $x2 = $this->x;
                $this->AddPage($this->CurOrientation, $this->CurPageSize);
                $this->x = $x2;
            }
            $y = $this->y;
            $this->y += $h;
        }

        if ($x === null)
            $x = $this->x;
        $this->_out(sprintf('q %.2F 0 0 %.2F %.2F %.2F cm /I%d Do Q', $w * $this->k, $h * $this->k, $x * $this->k, ($this->h - ($y + $h)) * $this->k, $info['i']));
        if ($link)
            $this->Link($x, $y, $w, $h, $link);
    }

    function GetX()
    {
        // Get x position
        return $this->x;
    }

    function SetX($x)
    {
        // Set x position
        if ($x >= 0)
            $this->x = $x;
        else
            $this->x = $this->w + $x;
    }

    function GetY()
    {
        // Get y position
        return $this->y;
    }

    function SetY($y)
    {
        // Set y position and reset x
        $this->x = $this->lMargin;
        if ($y >= 0)
            $this->y = $y;
        else
            $this->y = $this->h + $y;
    }

    function SetXY($x, $y)
    {
        // Set x and y positions
        $this->SetY($y);
        $this->SetX($x);
    }

    function GeraArquivoTemp(){
      return "tmp/rp".rand(1,10000)."_".time().".pdf";
    }

    /*function Output($name = '', $dest = '')
    {
        // Output PDF to some destination
        if ($this->state < 3)
            $this->Close();
        $dest = strtoupper($dest);
        if ($dest == '') {
            if ($name == '') {
                $name = 'doc.pdf';
                $dest = 'I';
            } else
                $dest = 'F';
        }
        switch ($dest) {
            case 'I':
                // Send to standard output
                $this->_checkoutput();
                if (PHP_SAPI != 'cli') {
                    // We send to a browser
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename="' . $name . '"');
                    header('Cache-Control: private, max-age=0, must-revalidate');
                    header('Pragma: public');
                }
                echo $this->buffer;
                break;
            case 'D':
                // Download file
                $this->_checkoutput();
                header('Content-Type: application/x-download');
                header('Content-Disposition: attachment; filename="' . $name . '"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                echo $this->buffer;
                break;
            case 'F':
                // Save to local file
                $f = fopen($name, 'wb');
                if (!$f)
                    $this->Error('Unable to create output file: ' . $name);
                fwrite($f, $this->buffer, strlen($this->buffer));
                fclose($f);
                break;
            case 'S':
                // Return as a string
                return $this->buffer;
            default:
                $this->Error('Incorrect output destination: ' . $dest);
        }
        return '';
    }*/

    function Output($file='',$download=false,$mostrar=false)
    //#00#//output
    //#10#//Salva um documento PDF em um arquivo local ou envia-o para o browser. Neste último caso, o  plug-in  será  usado
    //#10#//(se instalado) ou um download (caixa de diálogo "Salvar como") será apresentada.
    //#10#//O método primeiro chama |close|, se necessário para terminar o documento.
    //#15#//output($file='',$download=false)
    //#20#//file         : O nome do arquivo. Se vazio ou não informado, o documento será enviado ao browser para que ele  o
    //#20#//               use com o plug-in (se instalado).
    //#20#//download     : Se file for informado, indica que ele deve ser salvo localmente  (false) ou  mostrar a  caixa  de
    //#20#//               diálogo "Salvar como" no browser. Valor padrão: false.

    {
        if($file=='')
          $file = $this->GeraArquivoTemp();

      //Output PDF to file or browser
      global $HTTP_ENV_VARS;

      if($this->state<3)
        $this->Close();
      if($file=='')
      {
        //Send to browser
        Header('Content-Type: application/pdf');
                    header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");              // Date in the past
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
                    header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");                                    // HTTP/1.0
                    header("Cache-control: private");


        if(headers_sent())
            $this->Error('Some data has already been output to browser, can\'t send PDF file');
        Header('Content-Length: '.strlen($this->buffer));
        echo $this->buffer;

      }
      else
      {
              if($download)
        {

               if(isset($HTTP_ENV_VARS['HTTP_USER_AGENT']) and strpos($HTTP_ENV_VARS['HTTP_USER_AGENT'],'MSIE 5.5'))
                 Header('Content-Type: application/dummy');
               else
                 Header('Content-Type: application/octet-stream');
               if(headers_sent())
                 $this->Error('Some data has already been output to browser, can\'t send PDF file');
                 Header('Content-Length: '.strlen($this->buffer));
                 Header('Content-disposition: attachment; filename='.$file);
           echo $this->buffer;
        }
        else
        {

              ////////// NÃO RETIRAR ESSE IF SEM FALAR COM MARLON
              ////////// NECESSÁRIO PARA PROGRAMA DO MÓDULO PESSOAL
              ////////// geração de arquivos BB
              if($mostrar == false){
            header('Content-Type: application/pdf');
            header("Expires: Mon, 26 Jul 2001 05:00:00 GMT");              // Date in the past
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
            header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");                                    // HTTP/1.0
            header("Cache-control: private");
            echo $this->buffer;
              }


          //Save file locally
          $f=fopen($file,'wb');
          if(!$f)
            $this->Error('Unable to create output file: '.$file);
          fwrite($f,$this->buffer,strlen($this->buffer));
          fclose($f);

          $this->arquivo_retorno  = $file;

    //echo "<script>location.href='tmp/".$file."'</script>";


        }
      }
    }

    

    /*******************************************************************************
     *                                                                              *
     *                              Protected methods                               *
     *                                                                              *
     *******************************************************************************/
    function _dochecks()
    {
        // Check availability of %F
        if (sprintf('%.1F', 1.0) != '1.0')
            $this->Error('This version of PHP is not supported');
        // Check mbstring overloading
        if (ini_get('mbstring.func_overload') & 2)
            $this->Error('mbstring overloading must be disabled');
        // Ensure runtime magic quotes are disabled
        if (get_magic_quotes_runtime())
            @set_magic_quotes_runtime(0);
    }

    function _checkoutput()
    {
        if (PHP_SAPI != 'cli') {
            if (headers_sent($file, $line))
                $this->Error("Some data has already been output, can't send PDF file (output started at $file:$line)");
        }
        if (ob_get_length()) {
            // The output buffer is not empty
            if (preg_match('/^(\xEF\xBB\xBF)?\s*$/', ob_get_contents())) {
                // It contains only a UTF-8 BOM and/or whitespace, let's clean it
                ob_clean();
            } else
                $this->Error("Some data has already been output, can't send PDF file");
        }
    }

    function _getpagesize($size)
    {
        if (is_string($size)) {
            $size = strtolower($size);
            if (!isset($this->StdPageSizes[$size]))
                $this->Error('Unknown page size: ' . $size);
            $a = $this->StdPageSizes[$size];
            return array($a[0] / $this->k, $a[1] / $this->k);
        } else {
            if ($size[0] > $size[1])
                return array($size[1], $size[0]);
            else
                return $size;
        }
    }

    function _beginpage($orientation, $size)
    {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->state = 2;
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
        $this->FontFamily = '';
        // Check page size and orientation
        if ($orientation == '')
            $orientation = $this->DefOrientation;
        else
            $orientation = strtoupper($orientation[0]);
        if ($size == '')
            $size = $this->DefPageSize;
        else
            $size = $this->_getpagesize($size);
        if ($orientation != $this->CurOrientation || $size[0] != $this->CurPageSize[0] || $size[1] != $this->CurPageSize[1]) {
            // New size or orientation
            if ($orientation == 'P') {
                $this->w = $size[0];
                $this->h = $size[1];
            } else {
                $this->w = $size[1];
                $this->h = $size[0];
            }
            $this->wPt = $this->w * $this->k;
            $this->hPt = $this->h * $this->k;
            $this->PageBreakTrigger = $this->h - $this->bMargin;
            $this->CurOrientation = $orientation;
            $this->CurPageSize = $size;
        }
        if ($orientation != $this->DefOrientation || $size[0] != $this->DefPageSize[0] || $size[1] != $this->DefPageSize[1])
            $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
    }

    function _endpage()
    {
        $this->state = 1;
    }

    function _loadfont($font)
    {
        // Load a font definition file from the font directory
        include($this->fontpath . $font);
        $a = get_defined_vars();
        if (!isset($a['name']))
            $this->Error('Could not include font definition file');
        return $a;
    }

    function _escape($s)
    {
        // Escape special characters in strings
        $s = str_replace('\\', '\\\\', $s);
        $s = str_replace('(', '\\(', $s);
        $s = str_replace(')', '\\)', $s);
        $s = str_replace("\r", '\\r', $s);
        return $s;
    }

    function _textstring($s)
    {
        // Format a text string
        return '(' . $this->_escape($s) . ')';
    }

    function _UTF8toUTF16($s)
    {
        // Convert UTF-8 to UTF-16BE with BOM
        $res = "\xFE\xFF";
        $nb = strlen($s);
        $i = 0;
        while ($i < $nb) {
            $c1 = ord($s[$i++]);
            if ($c1 >= 224) {
                // 3-byte character
                $c2 = ord($s[$i++]);
                $c3 = ord($s[$i++]);
                $res .= chr((($c1 & 0x0F) << 4) + (($c2 & 0x3C) >> 2));
                $res .= chr((($c2 & 0x03) << 6) + ($c3 & 0x3F));
            } elseif ($c1 >= 192) {
                // 2-byte character
                $c2 = ord($s[$i++]);
                $res .= chr(($c1 & 0x1C) >> 2);
                $res .= chr((($c1 & 0x03) << 6) + ($c2 & 0x3F));
            } else {
                // Single-byte character
                $res .= "\0" . chr($c1);
            }
        }
        return $res;
    }

    function _dounderline($x, $y, $txt)
    {
        // Underline text
        $up = $this->CurrentFont['up'];
        $ut = $this->CurrentFont['ut'];
        $w = $this->GetStringWidth($txt) + $this->ws * substr_count($txt, ' ');
        return sprintf('%.2F %.2F %.2F %.2F re f', $x * $this->k, ($this->h - ($y - $up / 1000 * $this->FontSize)) * $this->k, $w * $this->k, -$ut / 1000 * $this->FontSizePt);
    }

    function _parsejpg($file)
    {
        // Extract info from a JPEG file
        $a = getimagesize($file);
        if (!$a)
            $this->Error('Missing or incorrect image file: ' . $file);
        if ($a[2] != 2)
            $this->Error('Not a JPEG file: ' . $file);
        if (!isset($a['channels']) || $a['channels'] == 3)
            $colspace = 'DeviceRGB';
        elseif ($a['channels'] == 4)
            $colspace = 'DeviceCMYK';
        else
            $colspace = 'DeviceGray';
        $bpc = isset($a['bits']) ? $a['bits'] : 8;
        $data = file_get_contents($file);
        return array('w' => $a[0], 'h' => $a[1], 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data);
    }

    function _parsepng($file)
    {
        // Extract info from a PNG file
        $f = fopen($file, 'rb');
        if (!$f)
            $this->Error('Can\'t open image file: ' . $file);
        $info = $this->_parsepngstream($f, $file);
        fclose($f);
        return $info;
    }

    function _parsepngstream($f, $file)
    {
        // Check signature
        if ($this->_readstream($f, 8) != chr(137) . 'PNG' . chr(13) . chr(10) . chr(26) . chr(10))
            $this->Error('Not a PNG file: ' . $file);

        // Read header chunk
        $this->_readstream($f, 4);
        if ($this->_readstream($f, 4) != 'IHDR')
            $this->Error('Incorrect PNG file: ' . $file);
        $w = $this->_readint($f);
        $h = $this->_readint($f);
        $bpc = ord($this->_readstream($f, 1));
        if ($bpc > 8)
            $this->Error('16-bit depth not supported: ' . $file);
        $ct = ord($this->_readstream($f, 1));
        if ($ct == 0 || $ct == 4)
            $colspace = 'DeviceGray';
        elseif ($ct == 2 || $ct == 6)
            $colspace = 'DeviceRGB';
        elseif ($ct == 3)
            $colspace = 'Indexed';
        else
            $this->Error('Unknown color type: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Unknown compression method: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Unknown filter method: ' . $file);
        if (ord($this->_readstream($f, 1)) != 0)
            $this->Error('Interlacing not supported: ' . $file);
        $this->_readstream($f, 4);
        $dp = '/Predictor 15 /Colors ' . ($colspace == 'DeviceRGB' ? 3 : 1) . ' /BitsPerComponent ' . $bpc . ' /Columns ' . $w;

        // Scan chunks looking for palette, transparency and image data
        $pal = '';
        $trns = '';
        $data = '';
        do {
            $n = $this->_readint($f);
            $type = $this->_readstream($f, 4);
            if ($type == 'PLTE') {
                // Read palette
                $pal = $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ($type == 'tRNS') {
                // Read transparency info
                $t = $this->_readstream($f, $n);
                if ($ct == 0)
                    $trns = array(ord(substr($t, 1, 1)));
                elseif ($ct == 2)
                    $trns = array(ord(substr($t, 1, 1)), ord(substr($t, 3, 1)), ord(substr($t, 5, 1)));
                else {
                    $pos = strpos($t, chr(0));
                    if ($pos !== false)
                        $trns = array($pos);
                }
                $this->_readstream($f, 4);
            } elseif ($type == 'IDAT') {
                // Read image data block
                $data .= $this->_readstream($f, $n);
                $this->_readstream($f, 4);
            } elseif ($type == 'IEND')
                break;
            else
                $this->_readstream($f, $n + 4);
        } while ($n);

        if ($colspace == 'Indexed' && empty($pal))
            $this->Error('Missing palette in ' . $file);
        $info = array('w' => $w, 'h' => $h, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'dp' => $dp, 'pal' => $pal, 'trns' => $trns);
        if ($ct >= 4) {
            // Extract alpha channel
            if (!function_exists('gzuncompress'))
                $this->Error('Zlib not available, can\'t handle alpha channel: ' . $file);
            $data = gzuncompress($data);
            $color = '';
            $alpha = '';
            if ($ct == 4) {
                // Gray image
                $len = 2 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.)./s', '$1', $line);
                    $alpha .= preg_replace('/.(.)/s', '$1', $line);
                }
            } else {
                // RGB image
                $len = 4 * $w;
                for ($i = 0; $i < $h; $i++) {
                    $pos = (1 + $len) * $i;
                    $color .= $data[$pos];
                    $alpha .= $data[$pos];
                    $line = substr($data, $pos + 1, $len);
                    $color .= preg_replace('/(.{3})./s', '$1', $line);
                    $alpha .= preg_replace('/.{3}(.)/s', '$1', $line);
                }
            }
            unset($data);
            $data = gzcompress($color);
            $info['smask'] = gzcompress($alpha);
            if ($this->PDFVersion < '1.4')
                $this->PDFVersion = '1.4';
        }
        $info['data'] = $data;
        return $info;
    }

    function _readstream($f, $n)
    {
        // Read n bytes from stream
        $res = '';
        while ($n > 0 && !feof($f)) {
            $s = fread($f, $n);
            if ($s === false)
                $this->Error('Error while reading stream');
            $n -= strlen($s);
            $res .= $s;
        }
        if ($n > 0)
            $this->Error('Unexpected end of stream');
        return $res;
    }

    function _readint($f)
    {
        // Read a 4-byte integer from stream
        $a = unpack('Ni', $this->_readstream($f, 4));
        return $a['i'];
    }

    function _parsegif($file)
    {
        // Extract info from a GIF file (via PNG conversion)
        if (!function_exists('imagepng'))
            $this->Error('GD extension is required for GIF support');
        if (!function_exists('imagecreatefromgif'))
            $this->Error('GD has no GIF read support');
        $im = imagecreatefromgif($file);
        if (!$im)
            $this->Error('Missing or incorrect image file: ' . $file);
        imageinterlace($im, 0);
        $f = @fopen('php://temp', 'rb+');
        if ($f) {
            // Perform conversion in memory
            ob_start();
            imagepng($im);
            $data = ob_get_clean();
            imagedestroy($im);
            fwrite($f, $data);
            rewind($f);
            $info = $this->_parsepngstream($f, $file);
            fclose($f);
        } else {
            // Use temporary file
            $tmp = tempnam('.', 'gif');
            if (!$tmp)
                $this->Error('Unable to create a temporary file');
            if (!imagepng($im, $tmp))
                $this->Error('Error while saving to temporary file');
            imagedestroy($im);
            $info = $this->_parsepng($tmp);
            unlink($tmp);
        }
        return $info;
    }

    function _newobj()
    {
        // Begin a new object
        $this->n++;
        $this->offsets[$this->n] = strlen($this->buffer);
        $this->_out($this->n . ' 0 obj');
    }

    function _putstream($s)
    {
        $this->_out('stream');
        $this->_out($s);
        $this->_out('endstream');
    }

    function _out($s)
    {
        // Add a line to the document
        if ($this->state == 2)
            $this->pages[$this->page] .= $s . "\n";
        else
            $this->buffer .= $s . "\n";
    }

    function _putpages()
    {
        $nb = $this->page;
        if (!empty($this->AliasNbPages)) {
            // Replace number of pages
            for ($n = 1; $n <= $nb; $n++)
                $this->pages[$n] = str_replace($this->AliasNbPages, $nb, $this->pages[$n]);
        }
        if ($this->DefOrientation == 'P') {
            $wPt = $this->DefPageSize[0] * $this->k;
            $hPt = $this->DefPageSize[1] * $this->k;
        } else {
            $wPt = $this->DefPageSize[1] * $this->k;
            $hPt = $this->DefPageSize[0] * $this->k;
        }
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; $n++) {
            // Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            if (isset($this->PageSizes[$n]))
                $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $this->PageSizes[$n][0], $this->PageSizes[$n][1]));
            $this->_out('/Resources 2 0 R');
            if (isset($this->PageLinks[$n])) {
                // Links
                $annots = '/Annots [';
                foreach ($this->PageLinks[$n] as $pl) {
                    $rect = sprintf('%.2F %.2F %.2F %.2F', $pl[0], $pl[1], $pl[0] + $pl[2], $pl[1] - $pl[3]);
                    $annots .= '<</Type /Annot /Subtype /Link /Rect [' . $rect . '] /Border [0 0 0] ';
                    if (is_string($pl[4]))
                        $annots .= '/A <</S /URI /URI ' . $this->_textstring($pl[4]) . '>>>>';
                    else {
                        $l = $this->links[$pl[4]];
                        $h = isset($this->PageSizes[$l[0]]) ? $this->PageSizes[$l[0]][1] : $hPt;
                        $annots .= sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]>>', 1 + 2 * $l[0], $h - $l[1] * $this->k);
                    }
                }
                $this->_out($annots . ']');
            }
            if ($this->PDFVersion > '1.3')
                $this->_out('/Group <</Type /Group /S /Transparency /CS /DeviceRGB>>');
            $this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
            $this->_out('endobj');
            // Page content
            $p = ($this->compress) ? gzcompress($this->pages[$n]) : $this->pages[$n];
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($p) . '>>');
            $this->_putstream($p);
            $this->_out('endobj');
        }
        // Pages root
        $this->offsets[1] = strlen($this->buffer);
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; $i++)
            $kids .= (3 + 2 * $i) . ' 0 R ';
        $this->_out($kids . ']');
        $this->_out('/Count ' . $nb);
        $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $wPt, $hPt));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putfonts()
    {
        $nf = $this->n;
        foreach ($this->diffs as $diff) {
            // Encodings
            $this->_newobj();
            $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences [' . $diff . ']>>');
            $this->_out('endobj');
        }
        foreach ($this->FontFiles as $file => $info) {
            // Font file embedding
            $this->_newobj();
            $this->FontFiles[$file]['n'] = $this->n;
            $font = file_get_contents($this->fontpath . $file, true);
            if (!$font)
                $this->Error('Font file not found: ' . $file);
            $compressed = (substr($file, -2) == '.z');
            if (!$compressed && isset($info['length2']))
                $font = substr($font, 6, $info['length1']) . substr($font, 6 + $info['length1'] + 6, $info['length2']);
            $this->_out('<</Length ' . strlen($font));
            if ($compressed)
                $this->_out('/Filter /FlateDecode');
            $this->_out('/Length1 ' . $info['length1']);
            if (isset($info['length2']))
                $this->_out('/Length2 ' . $info['length2'] . ' /Length3 0');
            $this->_out('>>');
            $this->_putstream($font);
            $this->_out('endobj');
        }
        foreach ($this->fonts as $k => $font) {
            // Font objects
            $this->fonts[$k]['n'] = $this->n + 1;
            $type = $font['type'];
            $name = $font['name'];
            if ($type == 'Core') {
                // Core font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /Type1');
                if ($name != 'Symbol' && $name != 'ZapfDingbats')
                    $this->_out('/Encoding /WinAnsiEncoding');
                $this->_out('>>');
                $this->_out('endobj');
            } elseif ($type == 'Type1' || $type == 'TrueType') {
                // Additional Type1 or TrueType/OpenType font
                $this->_newobj();
                $this->_out('<</Type /Font');
                $this->_out('/BaseFont /' . $name);
                $this->_out('/Subtype /' . $type);
                $this->_out('/FirstChar 32 /LastChar 255');
                $this->_out('/Widths ' . ($this->n + 1) . ' 0 R');
                $this->_out('/FontDescriptor ' . ($this->n + 2) . ' 0 R');
                if (isset($font['diffn']))
                    $this->_out('/Encoding ' . ($nf + $font['diffn']) . ' 0 R');
                else
                    $this->_out('/Encoding /WinAnsiEncoding');
                $this->_out('>>');
                $this->_out('endobj');
                // Widths
                $this->_newobj();
                $cw = &$font['cw'];
                $s = '[';
                for ($i = 32; $i <= 255; $i++)
                    $s .= $cw[chr($i)] . ' ';
                $this->_out($s . ']');
                $this->_out('endobj');
                // Descriptor
                $this->_newobj();
                $s = '<</Type /FontDescriptor /FontName /' . $name;
                foreach ($font['desc'] as $k => $v)
                    $s .= ' /' . $k . ' ' . $v;
                if (!empty($font['file']))
                    $s .= ' /FontFile' . ($type == 'Type1' ? '' : '2') . ' ' . $this->FontFiles[$font['file']]['n'] . ' 0 R';
                $this->_out($s . '>>');
                $this->_out('endobj');
            } else {
                // Allow for additional types
                $mtd = '_put' . strtolower($type);
                if (!method_exists($this, $mtd))
                    $this->Error('Unsupported font type: ' . $type);
                $this->$mtd($font);
            }
        }
    }

    function _putimages()
    {
        foreach (array_keys($this->images) as $file) {
            $this->_putimage($this->images[$file]);
            unset($this->images[$file]['data']);
            unset($this->images[$file]['smask']);
        }
    }

    function _putimage(&$info)
    {
        $this->_newobj();
        $info['n'] = $this->n;
        $this->_out('<</Type /XObject');
        $this->_out('/Subtype /Image');
        $this->_out('/Width ' . $info['w']);
        $this->_out('/Height ' . $info['h']);
        if ($info['cs'] == 'Indexed')
            $this->_out('/ColorSpace [/Indexed /DeviceRGB ' . (strlen($info['pal']) / 3 - 1) . ' ' . ($this->n + 1) . ' 0 R]');
        else {
            $this->_out('/ColorSpace /' . $info['cs']);
            if ($info['cs'] == 'DeviceCMYK')
                $this->_out('/Decode [1 0 1 0 1 0 1 0]');
        }
        $this->_out('/BitsPerComponent ' . $info['bpc']);
        if (isset($info['f']))
            $this->_out('/Filter /' . $info['f']);
        if (isset($info['dp']))
            $this->_out('/DecodeParms <<' . $info['dp'] . '>>');
        if (isset($info['trns']) && is_array($info['trns'])) {
            $trns = '';
            for ($i = 0; $i < count($info['trns']); $i++)
                $trns .= $info['trns'][$i] . ' ' . $info['trns'][$i] . ' ';
            $this->_out('/Mask [' . $trns . ']');
        }
        if (isset($info['smask']))
            $this->_out('/SMask ' . ($this->n + 1) . ' 0 R');
        $this->_out('/Length ' . strlen($info['data']) . '>>');
        $this->_putstream($info['data']);
        $this->_out('endobj');
        // Soft mask
        if (isset($info['smask'])) {
            $dp = '/Predictor 15 /Colors 1 /BitsPerComponent 8 /Columns ' . $info['w'];
            $smask = array('w' => $info['w'], 'h' => $info['h'], 'cs' => 'DeviceGray', 'bpc' => 8, 'f' => $info['f'], 'dp' => $dp, 'data' => $info['smask']);
            $this->_putimage($smask);
        }
        // Palette
        if ($info['cs'] == 'Indexed') {
            $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
            $pal = ($this->compress) ? gzcompress($info['pal']) : $info['pal'];
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($pal) . '>>');
            $this->_putstream($pal);
            $this->_out('endobj');
        }
    }

    function _putxobjectdict()
    {
        foreach ($this->images as $image)
            $this->_out('/I' . $image['i'] . ' ' . $image['n'] . ' 0 R');
    }

    function _putresourcedict()
    {
        $this->_out('/ProcSet [/PDF /Text /ImageB /ImageC /ImageI]');
        $this->_out('/Font <<');
        foreach ($this->fonts as $font)
            $this->_out('/F' . $font['i'] . ' ' . $font['n'] . ' 0 R');
        $this->_out('>>');
        $this->_out('/XObject <<');
        $this->_putxobjectdict();
        $this->_out('>>');
    }

    function _putresources()
    {
        $this->_putfonts();
        $this->_putimages();
        // Resource dictionary
        $this->offsets[2] = strlen($this->buffer);
        $this->_out('2 0 obj');
        $this->_out('<<');
        $this->_putresourcedict();
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putinfo()
    {
        $this->_out('/Producer ' . $this->_textstring('FPDF ' . FPDF_VERSION));
        if (!empty($this->title))
            $this->_out('/Title ' . $this->_textstring($this->title));
        if (!empty($this->subject))
            $this->_out('/Subject ' . $this->_textstring($this->subject));
        if (!empty($this->author))
            $this->_out('/Author ' . $this->_textstring($this->author));
        if (!empty($this->keywords))
            $this->_out('/Keywords ' . $this->_textstring($this->keywords));
        if (!empty($this->creator))
            $this->_out('/Creator ' . $this->_textstring($this->creator));
        $this->_out('/CreationDate ' . $this->_textstring('D:' . @date('YmdHis')));
    }

    function _putcatalog()
    {
        $this->_out('/Type /Catalog');
        $this->_out('/Pages 1 0 R');
        if ($this->ZoomMode == 'fullpage')
            $this->_out('/OpenAction [3 0 R /Fit]');
        elseif ($this->ZoomMode == 'fullwidth')
            $this->_out('/OpenAction [3 0 R /FitH null]');
        elseif ($this->ZoomMode == 'real')
            $this->_out('/OpenAction [3 0 R /XYZ null null 1]');
        elseif (!is_string($this->ZoomMode))
            $this->_out('/OpenAction [3 0 R /XYZ null null ' . sprintf('%.2F', $this->ZoomMode / 100) . ']');
        if ($this->LayoutMode == 'single')
            $this->_out('/PageLayout /SinglePage');
        elseif ($this->LayoutMode == 'continuous')
            $this->_out('/PageLayout /OneColumn');
        elseif ($this->LayoutMode == 'two')
            $this->_out('/PageLayout /TwoColumnLeft');
    }

    function _putheader()
    {
        $this->_out('%PDF-' . $this->PDFVersion);
    }

    function _puttrailer()
    {
        $this->_out('/Size ' . ($this->n + 1));
        $this->_out('/Root ' . $this->n . ' 0 R');
        $this->_out('/Info ' . ($this->n - 1) . ' 0 R');
    }

    function _enddoc()
    {
        $this->_putheader();
        $this->_putpages();
        $this->_putresources();
        // Info
        $this->_newobj();
        $this->_out('<<');
        $this->_putinfo();
        $this->_out('>>');
        $this->_out('endobj');
        // Catalog
        $this->_newobj();
        $this->_out('<<');
        $this->_putcatalog();
        $this->_out('>>');
        $this->_out('endobj');
        // Cross-ref
        $o = strlen($this->buffer);
        $this->_out('xref');
        $this->_out('0 ' . ($this->n + 1));
        $this->_out('0000000000 65535 f ');
        for ($i = 1; $i <= $this->n; $i++)
            $this->_out(sprintf('%010d 00000 n ', $this->offsets[$i]));
        // Trailer
        $this->_out('trailer');
        $this->_out('<<');
        $this->_puttrailer();
        $this->_out('>>');
        $this->_out('startxref');
        $this->_out($o);
        $this->_out('%%EOF');
        $this->state = 3;
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function bold() {
      $this->SetFont('','B');
    }
   
    function endbold() {
      $this->SetFont('','');
    }
   function WriteText($text)
   {
       $intPosIni = 0;
       $intPosFim = 0;
       if (strpos($text,'<')!==false and strpos($text,'[')!==false)
       {
           if (strpos($text,'<')<strpos($text,'['))
           {
               $this->Write(5,substr($text,0,strpos($text,'<')));
               $intPosIni = strpos($text,'<');
               $intPosFim = strpos($text,'>');
               $this->SetFont('','B');
               $this->Write(5,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
               $this->SetFont('','');
               $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
           }
           else
           {
               $this->Write(5,substr($text,0,strpos($text,'[')));
               $intPosIni = strpos($text,'[');
               $intPosFim = strpos($text,']');
               $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
               $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
               $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
           }
       }
       else
       {
           if (strpos($text,'<')!==false)
           {
               $this->Write(5,substr($text,0,strpos($text,'<')));
               $intPosIni = strpos($text,'<');
               $intPosFim = strpos($text,'>');
               $this->SetFont('','B');
               $this->WriteText(substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
               $this->SetFont('','');
               $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
           }
           elseif (strpos($text,'[')!==false)
           {
               $this->Write(5,substr($text,0,strpos($text,'[')));
               $intPosIni = strpos($text,'[');
               $intPosFim = strpos($text,']');
               $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
               $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
               $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
           }
           else
           {
               $this->Write(5,$text);
           }
   
       }
   }
   
     /**
      *  Retorna o altura disponivel para escrita
      *  @return integer
      */
     public function getAvailHeight() {
   
        $nAlturaPagina = $this->h;
        $iPosicaoAtual = $this->getY();
        $iMargemBaixa  = $this->bMargin;
        $nResultado    = ( $nAlturaPagina - $iPosicaoAtual ) - $iMargemBaixa;
        return (float)$nResultado;
     }
   
     /**
      * Retorna a largura disponível para escrita
      * @return float
      */
     public function getAvailWidth() {
   
       $nLarguraPagina = $this->w;
       $iPosicaoAtual  = $this->getX();
       $iMargemDireita = $this->rMargin;
       $nResultado     = ( $nLarguraPagina - $iPosicaoAtual ) - $iMargemDireita;
   
       return (float) $nResultado;
     }
   
     function VCell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false) {
       //Output a cell
       $k=$this->k;
       if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
       {
         //Automatic page break
         $x=$this->x;
         $ws=$this->ws;
         if($ws>0)
         {
           $this->ws=0;
           $this->_out('0 Tw');
         }
         $this->AddPage($this->CurOrientation,$this->CurPageFormat);
         $this->x=$x;
         if($ws>0)
         {
           $this->ws=$ws;
           $this->_out(sprintf('%.3F Tw',$ws*$k));
         }
       }
       if($w==0)
         $w=$this->w-$this->rMargin-$this->x;
       $s='';
       // begin change Cell function
       if($fill || $border>0)
       {
         if($fill)
           $op=($border>0) ? 'B' : 'f';
         else
           $op='S';
         if ($border>1) {
           $s=sprintf('q %.2F w %.2F %.2F %.2F %.2F re %s Q ',$border,
                      $this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
         }
         else
           $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
       }
       if(is_string($border))
       {
         $x=$this->x;
         $y=$this->y;
         if(is_int(strpos($border,'L')))
           $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
         else if(is_int(strpos($border,'l')))
           $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
   
         if(is_int(strpos($border,'T')))
           $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
         else if(is_int(strpos($border,'t')))
           $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
   
         if(is_int(strpos($border,'R')))
           $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
         else if(is_int(strpos($border,'r')))
           $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
   
         if(is_int(strpos($border,'B')))
           $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
         else if(is_int(strpos($border,'b')))
           $s.=sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
       }
       if(trim($txt)!='')
       {
         $cr=substr_count($txt,"\n");
         if ($cr>0) { // Multi line
           $txts = explode("\n", $txt);
           $lines = count($txts);
           for($l=0;$l<$lines;$l++) {
             $txt=$txts[$l];
             $w_txt=$this->GetStringWidth($txt);
             if ($align=='U')
               $dy=$this->cMargin+$w_txt;
             elseif($align=='D')
               $dy=$h-$this->cMargin;
             else
               $dy=($h+$w_txt)/2;
             $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
             if($this->ColorFlag)
               $s.='q '.$this->TextColor.' ';
             $s.=sprintf('BT 0 1 -1 0 %.2F %.2F Tm (%s) Tj ET ',
                         ($this->x+.5*$w+(.7+$l-$lines/2)*$this->FontSize)*$k,
                         ($this->h-($this->y+$dy))*$k,$txt);
             if($this->ColorFlag)
               $s.=' Q ';
           }
         }
         else { // Single line
           $w_txt=$this->GetStringWidth($txt);
           $Tz=100;
           if ($w_txt>$h-2*$this->cMargin) {
             $Tz=($h-2*$this->cMargin)/$w_txt*100;
             $w_txt=$h-2*$this->cMargin;
           }
           if ($align=='U')
             $dy=$this->cMargin+$w_txt;
           elseif($align=='D')
             $dy=$h-$this->cMargin;
           else
             $dy=($h+$w_txt)/2;
           $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
           if($this->ColorFlag)
             $s.='q '.$this->TextColor.' ';
           $s.=sprintf('q BT 0 1 -1 0 %.2F %.2F Tm %.2F Tz (%s) Tj ET Q ',
                       ($this->x+.5*$w+.3*$this->FontSize)*$k,
                       ($this->h-($this->y+$dy))*$k,$Tz,$txt);
           if($this->ColorFlag)
             $s.=' Q ';
         }
       }
       // end change Cell function
       if($s)
         $this->_out($s);
       $this->lasth=$h;
       if($ln>0)
       {
         //Go to next line
         $this->y+=$h;
         if($ln==1)
           $this->x=$this->lMargin;
       }
       else
         $this->x+=$w;
     }

    function Row($data, $altura = 5, $borda = true, $espaco = 5, $preenche = 0, $naousaespaco = false)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = $espaco * $nb;
        //Issue a page break first if needed
        // Carlos >>  $this->CheckPageBreak($h);
        //Draw the cells of the row
        $posinicial = $this->GetY();
        $posfinal = 0;
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($borda == true)
                $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, $altura, $data[$i], 0, $a, $preenche);
            //Put the position to the right of the cell
            if ($this->GetY() > $posfinal) {
                $posfinal = $this->GetY();
            }
            $this->SetXY($x + $w, $y);
        }

        // Adicionado novo parâmetro:
        // Parârametro: NAOUSAESPACO
        // Se $naousaespaco não for setado ao chamar a função ROW ou for setado com FALSE, o ln() continuará
        // usando a variável $h para pular para a próxima linha. Caso contrário, o ln() será a posição final
        // do maior multicell menos a posição em que este começou a ser impresso...
        if ($naousaespaco == true) {
            //Go to the next line
            $this->Ln($posfinal - $posinicial);
        } else {
            //Go to the next line
            $this->Ln($h);
        }
    }

    ///FUNÇÃO PARA TESTAR O RETORNO DO RESTANTE DE UMA STRING AO QUEBRAR DE PÁGINA
    function Row_multicell(
        $data,
        $altura = 5,
        $borda = true,
        $espaco = 5,
        $preenche = 0,
        $naousaespaco = false,
        $usar_quebra = false,
        $campo_testar = null,
        $altpag = null,
        $lagurafixa = 0,
        $aNegritos = null
    ) {
        //precisa ser feita melhoria nesse metodo. Acerto temporario realizado na tarefa 61771
        //Calculate the height of the row
        if ($altpag == null) {
            $altpag = $this->h;
        }
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {

            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            $h = $espaco * $nb;
            //Issue a page break first if needed
            // Carlos >>  $this->CheckPageBreak($h);
            //Draw the cells of the row
            $posinicial = $this->GetY();
            $posfinal = 0;

            // Variável que retorna o restante da string
            $retorno_quebra_string = "";
            for ($i = 0; $i < count($data); $i++) {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

                //Save the current position
                $x = $this->GetX();
                $y = $this->GetY();

                //Draw the border
                if ($borda == true) {
                    $this->Rect($x, $y, $w, $h);
                }

                $imprime_dados_string = $data[$i];

                // Se for para retornar string no limite da quebra de página
                // e campo corrente for o informado por parâmetro
                if ($usar_quebra == true && $i == $campo_testar) {
                    $yy = split("\n", $data[$i]);
                    $imprime_dados_string = "";

                    for ($xx = 0; $xx < count($yy); $xx++) {
                        $alturatesta = ($this->GetY() + ($altura * $xx));
                        $alturatesta = (int)$alturatesta;
                        $qtdlinhas = $this->NbLines($w, $yy[$xx] . ($xx + 1 == count($yy) ? "" : "\n"));
                        $altpag -= ($qtdlinhas - 1) * $altura;

                        if ($alturatesta < $altpag) {
                            $imprime_dados_string .= $yy[$xx] . ($xx + 1 == count($yy) ? "" : "\n");
                        } else {
                            $retorno_quebra_string .= $yy[$xx] . ($xx + 1 == count($yy) ? "" : "\n");
                        }
                    }
                }

                if (isset($aNegritos[$i]) && $aNegritos[$i] === true) {
                    $this->bold();
                }
                //Print the text
                if ($lagurafixa == 0) {
                    $this->MultiCell($w, $altura, $imprime_dados_string, 0, $a, $preenche);
                } else {
                    $this->MultiCell($lagurafixa, $altura, $imprime_dados_string, 0, $a, $preenche);
                }
                if (isset($aNegritos[$i]) && $aNegritos[$i] === true) {
                    $this->endbold();
                }
                //Put the position to the right of the cell
                if ($this->GetY() > $posfinal) {
                    $posfinal = $this->GetY();
                }
                $this->SetXY($x + $w, $y);
            }

            // Adicionado novo parâmetro:
            // Parârametro: NAOUSAESPACO
            // Se $naousaespaco não for setado ao chamar a função ROW ou for setado com FALSE, o ln() continuará
            // usando a variável $h para pular para a próxima linha. Caso contrário, o ln() será a posição final
            // do maior multicell menos a posição em que este começou a ser impresso...
            if ($naousaespaco == true) {
                //Go to the next line
                $this->Ln($posfinal - $posinicial);
            } else {
                //Go to the next line
                $this->Ln($h);
            }

            return $retorno_quebra_string;
        }
    }
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }
    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k));
        if (strpos($angle, '2') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '3') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($angle, '4') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '1') === false) {
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $y) * $k));
        } else {
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
            $this->_out($op);
        }
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2f %.2f %.2f %.2f %.2f %.2f c',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }

    function PieChart($w, $h, $data, $format, $colors = null)  /// graficos tipo pizza
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $hLegend = 3;
        $radius = min($w - $margin * 4 - $hLegend - $this->wLegend, $h - $margin * 2);
        $radius = floor($radius / 2);
        $XDiag = $XPage + $margin + $radius;
        $YDiag = $YPage + $margin + $radius;
        if ($colors == null) {
            for ($i = 0; $i < $this->NbVal; $i++) {
                $gray = $i * intval(255 / $this->NbVal);
                $colors[$i] = array($gray, $gray, $gray);
            }
        }

        //Sectors
        $this->SetLineWidth(0.2);
        $angleStart = 0;
        $angleEnd = 0;
        $i = 0;
        foreach ($data as $val) {
            $angle = floor(($val * 360) / doubleval($this->sum));
            if ($angle != 0) {
                $angleEnd = $angleStart + $angle;
                @$this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
                $this->Sector($XDiag, $YDiag, $radius, $angleStart, $angleEnd);
                $angleStart += $angle;
            }
            $i++;
        }
        if ($angleEnd != 360) {
            $this->Sector($XDiag, $YDiag, $radius, $angleStart - $angle, 360);
        }

        //Legends
        $this->SetFont('Courier', '', 8);
        $x1 = $XPage + 2 * $radius + 4 * $margin;
        $x2 = $x1 + $hLegend + $margin;
        $y1 = $YDiag - $radius + (2 * $radius - $this->NbVal * ($hLegend + $margin)) / 2;
        for ($i = 0; $i < $this->NbVal; $i++) {

            if ($this->getY() > $this->h - 20) {

                $this->AddPage();
                $y1 = 40;
            }
            @$this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
            $this->Rect($x1, $y1, $hLegend, $hLegend, 'DF');
            $this->SetXY($x2, $y1);
            $this->Cell(0, $hLegend, $this->legends[$i]);
            $y1 += $hLegend + $margin;
        }
    }

    function BarDiagram($w, $h, $data, $format, $color = null, $maxVal = 0, $nbDiv = 4)  /// graficos tipo barra
    {
        $this->SetFont('Courier', '', 10);
        $this->SetLegends($data, $format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if ($color == null)
            $color = array(155, 155, 155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = $valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.2);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Courier', '', 10);

        $i = 0;
        $xcor = 0;

        foreach ($data as $val) {
            if ($xcor == 0 || count($color) == 3) {
                $xcor = 1;
                if (count($color) < 3) {
                    $this->SetFillColor($color[0]);
                } else {
                    $this->SetFillColor($color[0], $color[1], $color[2]);
                }
            } else {
                $xcor = 0;
                if (count($color) < 3) {
                    $this->SetFillColor($color[1]);
                } else {
                    $this->SetFillColor($color[3], $color[4], $color[5]);
                }
            }
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(0, $yval);
            $this->Cell($xval - $margin, $hval, $this->legends[$i], 0, 0, 'R');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }
    // End of class

    function int25($xp,$yp,$text,$alt,$larg)
    {
        if (empty($text)) {
          return ;
        }
        $xpos = $xp;
        $text = strtoupper($text);
        $barcodeheight = $alt;                               // seta a altura das barras
        $barcodethinwidth = $larg;                             // seta a largura da barra estreita
        $barcodethickwidth = $barcodethinwidth * 2.2;          // seta a relacao barra larga/barra estreita
        // seta os codigos dos caracteres, sendo 0 para estreito e 1 para largo
        $codingmap  =  Array(
        "0"=>  "00110",  "1"=>  "10001",
        "2"=>  "01001",  "3"=>  "11000",
        "4"=>  "00101",  "5"=>  "10100",
        "6"=>  "01100",  "7"=>  "00011",
        "8"=>  "10010",  "9"=>  "01010");
        // se no. de caracteres impar adiciona 0 no comeco
        if(strlen($text)%2)
        $text = "0".$text;
    
        $textlen = strlen($text);
        $barcodewidth  = ($textlen)*(3*$barcodethinwidth + 2*$barcodethickwidth)+($textlen)*(2.5)+(7*$barcodethinwidth + $barcodethickwidth)+3;
        // imprime na imagem o codigo de inicio
        $elementwidth = $barcodethinwidth;
        for($i = 0;$i < 2;$i++) {
          //imagefilledrectangle($im, $xpos, 0, $xpos + $elementwidth - 1 , $barcodeheight, $black);
        $this->Rect($xpos, $yp, $xpos + $elementwidth-$xpos, $barcodeheight,"F");
          $xpos += $elementwidth;
          $xpos += $barcodethinwidth;
        //$elementwidth = $barcodethickwidth;
          //$xpos ++;
        }
        // imprime na imagem o codigo em si
        for($idx = 0;$idx < $textlen;$idx += 2)  {      // a impressao e feita 2 caracteres por vez
          $charimpar = substr($text,$idx,1);    // pega o caracter impar, que vai ser impresso em preto
          $charpar  =  substr($text,$idx+1,1);    // pega o caracter par, que vai ser impresso em branco
          // interlacamento
          for($baridx = 0;$baridx < 5;$baridx++)  {  // a cada bit do codigo dos caracteres
            // imprime a barra coresspondente ao bit do caractere impar (preto)
            $elementwidth = (substr($codingmap[$charimpar],$baridx,1)) ?  $barcodethickwidth : $barcodethinwidth;
            //imagefilledrectangle($im, $xpos,0, $xpos + $elementwidth - 1,$barcodeheight, $black);
          $this->Rect($xpos, $yp, $xpos + $elementwidth-$xpos, $barcodeheight,"F");
            $xpos += $elementwidth;
            // deixa o espaco correspondente ao bit do caractere par (branco)
            $elementwidth = (substr($codingmap[$charpar],$baridx,1)) ?  $barcodethickwidth : $barcodethinwidth;
            $xpos += $elementwidth;
            //$xpos ++;
          }
        }
        // imprime o codigo de final
        $elementwidth = $barcodethickwidth;
        $this->Rect($xpos, $yp, $xpos + $elementwidth-$xpos, $barcodeheight,"F");
        $xpos += $elementwidth;
        $xpos += $barcodethinwidth;
        $elementwidth = $barcodethinwidth;
        $this->Rect($xpos, $yp, $xpos + $elementwidth-$xpos, $barcodeheight,"F");
    }
    
    function TextWithDirection($x,$y,$txt,$direction='R')
    {
        $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
        if ($direction=='R')
            $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$txt);
        elseif ($direction=='L')
            $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$txt);
        elseif ($direction=='U')
            $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
        elseif ($direction=='D')
            $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
        else
            $s=sprintf('BT %.2f %.2f Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$txt);
        $this->_out($s);
    }
    
    function TextWithRotation($x,$y,$txt,$txt_angle,$font_angle=0)
    {
        $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
    
        $font_angle+=90+$txt_angle;
        $txt_angle*=M_PI/180;
        $font_angle*=M_PI/180;
    
        $txt_dx=cos($txt_angle);
        $txt_dy=sin($txt_angle);
        $font_dx=cos($font_angle);
        $font_dy=sin($font_angle);
    
        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
                 $txt_dx,$txt_dy,$font_dx,$font_dy,
                 $x*$this->k,($this->h-$y)*$this->k,$txt);
        $this->_out($s);
    }    
}

// Handle special IE contype request
if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] == 'contype') {
    header('Content-Type: application/pdf');
    exit;
}
