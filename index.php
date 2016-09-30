<?php
if(isset($_POST['pa'])){unset($_POST);}
if(!isset($_POST['l'])){$l=1;}else{$l=$_POST['l'];}
if(isset($_POST['nl'])){$l++;}
function xy($ar){
        $nar=array();
        foreach($ar as $xk => $yks){
            foreach($yks as $yk => $n){
                
                $nar[$yk][$xk]=$n;
            }
            
        }
        
        return $nar;
    }
$er=0;
if(isset($_POST['x']) && !isset($_POST['nl'])){
    $x=$_POST['x'];
    $dx=$_POST['dx'];
    function check($x,$dx){
        
        foreach($x as $xk => $yks){
            $l=0;
            foreach($yks as $yk=> $n){
                if($n==''){
                    if(isset($dx[$xk][$yk])){
                        $n=$dx[$xk][$yk];
                        $x[$xk][$yk]=$n;
                    }else{
                         
                        return false;}
                }
               
                $l=$l+$n;
            }
            
            if($l!=45){
               
                return false;}
        }
        return $x;
    }
    $ch=check($x,$dx);
  
    $er=0;
    if($ch){
        
        $y=xy($ch);
        $rch=check($y,$dx);
        if(!$rch){
            
            $er=1;}
    }else{$er=1;}
    
}elseif(isset($_POST['nl']) || !isset($_POST['x'])){
    $starts=array(
        '0'=>array(
             
                array(1,3,6,4,2,8,5,9,7),
                array(2,4,5,6,7,9,1,8,3),
                array(7,8,9,1,3,5,6,2,4),
                array(3,5,7,8,9,1,2,4,6),
                array(4,6,8,2,5,7,9,3,1),
                array(9,1,2,3,4,6,7,5,8),
                array(8,7,4,9,6,2,3,1,5),
                array(5,9,1,7,8,3,4,6,2),
                array(6,2,3,5,1,4,8,7,9),
                
            
        ),
        '1'=>array(
                0=> array(5,2,7,3,9,8,6,1,4),
                 1=>array(6,8,9,5,4,1,7,2,3),
                 2=>array(1,3,4,2,6,7,5,8,9),
                 3=>array(8,4,1,9,7,6,2,3,5),
                 4=>array(7,5,2,4,1,3,9,6,8),
                 5=>array(3,9,6,8,5,2,1,4,7),
                 6=>array(2,6,5,7,8,4,3,9,1),
                 7=>array(4,7,3,1,2,9,8,5,6),
                 8=>array(9,1,8,6,3,5,4,7,2),
            
        
        
        ),
        '2'=>array(
               0=> array(7,2,6,8,9,1,4,5,3),
                 1=> array(9,3,8,4,6,5,7,2,1),
                 2=> array(1,4,5,7,3,2,9,8,6),
                 3=> array(8,1,3,9,2,6,5,7,4),
                 4=> array(2,7,9,1,5,4,6,3,8),
                 5=> array(5,6,4,3,7,8,2,1,9),
                 6=> array(6,8,2,5,1,9,3,4,7),
                 7=> array(4,9,7,2,8,3,1,6,5),
                 8=> array(3,5,1,6,4,7,8,9,2),
            
        ),
        
    
    
    
    
    );
   

    
    function changeline($x,$l1){
         
        if($l1<3){$in=array(0,1,2);}elseif($l1<6){$in=array(3,4,5);}else{$in=array(6,7,8);}
        $ol=array_diff($in,array($l1));
        shuffle($ol);
   
        $l2=array_values($ol)[0];
        
        $la1=$x[$l1];
        $la2=$x[$l2];
        $x[$l1]=$la2;
        $x[$l2]=$la1;
        return $x;
    }
    function createchangecombination(){
        $max=9;
        $cn=rand(0,$max);
        $comb=array();
        for($i=0;$i<($cn+1);$i++){
            $ct=rand(0,1);
            if($ct==1){
                $l=rand(0,8);
                $comb[]=$l;
            }else{
                $comb[]='xy';
            }
        }
        return $comb;
    }
    function change($x,$combs){
        
        foreach($combs as $comb){
            
            if($comb=='xy'){
                $x=xy($x);
                
            }else{
           
                $x=changeline($x,$comb);
            }
        }
        return $x;
    }
    function delnums($l,$x){
        $dels=$l*6;
          for($i=0;$i<($dels+1);$i++){
              $p=rand(0,8);
              $p2=rand(0,8);
              $x[$p][$p2]='';
        }
        return $x;
    }
    $r=rand(0,2);
    $x=$starts[$r];

$comb=createchangecombination();
$new=change($x,$comb);
$deleted=delnums($l,$new);
$x= $deleted;
}
 
$table='<table cellspacing="0" cellpadding="0" border="0"><tbody>';
foreach($x as $xk => $yks){
    $table.='<tr>';
    foreach($yks as $yk => $n){
         
        if($n!=''){
        $table.='<td><input type="text" name="x['.$xk.']['.$yk.']" value="'.$n.'" readonly="readonly" /></td>';
            }else{
            if(isset($_POST['dx'][$xk][$yk]) && !isset($_POST['nl'])) $n=$_POST['dx'][$xk][$yk];
             $table.='<td><input type="hidden" name="x['.$xk.']['.$yk.']" value=""/><input type="text" name="dx['.$xk.']['.$yk.']" value="'.$n.'"  /></td>';
        }
                  
    }
     $table.='</tr>';
}
$table.='</tbody></table>';
$submit='Check';
if(!isset($_POST['nl'])){
if($er==1 ){$table='<p>There is some mistakes</p>'.$table;
          $submit='Check Again';
          }elseif(($er==0) && isset($_POST['x'])){
    if($l==10){
         $table='<p class="g">Congratulations!!! You are finished the game.</p><input type="hidden" name="pa" value="1"/>'.$table;
     $submit='Play Again';
        
    }else{ 
    $table='<p class="g">Successful</p><input type="hidden" name="nl" value="1"/>'.$table;
     $submit='Next Level';
}
}}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SUDOKU</title>
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
    <div id="content">
        <h1>SUDOKU</h1>
        <form action="index.php" method="post" autocomplete="off">
           <?=$table?>
            <span>Level:</span><input type="text" readonly="readonly" name="l" class="l" value="<?=$l;?>"/>
            <input type="submit" value="<?=$submit?>"/>
            
        </form>
        
    </div>
</body>
</html>