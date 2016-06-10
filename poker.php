<?php 
class card_deck 
{ 
    private $types = array(); 
    private $deck = array(); 
    private $count = array(); 
    
    public function add_type($property_name, $type_names, $count = 1, $id = -1){ 
        $arr = array(); 

        // Found on stack overflow. Thought was interesting: 
        // --->   ?:  <--- is another way to write an if statement with an else statement
        //   if             True                    : False
        //  $id<0  ? sizeof($this->types)(True side): $id;
        $cnt = ($id < 0) ? sizeof($this->types): $id; 
        foreach($type_names as $key => $value) 
        { 
            $arr[] = $value; 
        } 
        if(!isset($this->count[$cnt])) 
        { 
            $this->count[$cnt] = 1; 
        } 
        $this->count[$cnt] *= sizeof($arr); 
        $this->count[$cnt] *= $count; 
        $this->types[$cnt][$property_name] = $arr; 
        $this->deck = range(0, array_sum($this->count) - 1); 
        return $cnt; 
    } 
    
    public function shuffle($reset = true){ 
        if($reset) 
        { 
            $this->deck = range(0, array_sum($this->count) - 1); 
        } 
        shuffle($this->deck); 
    } 
    
    public function deal($count){ 
        $arr = array(); 
        for($i = 1; $i <= $count; $i++) 
        { 
            if(!empty($this->deck)) 
            { 
                $cnt = sizeof($arr); 
                $card = array_shift($this->deck); 
                $sub = 0; 
                foreach($this->types as $card_type => $value) 
                { 
                    if($card < $this->count[$card_type] + $sub) 
                    { 
                        $mod = 1; 
                        foreach($value as $key => $val) 
                        { 
                            $arr[$cnt][$key] = $val[round(($card - $sub)/$mod) % sizeof($val)]; 
                            $mod *= sizeof($val); 
                        } 
                        break; 
                    } 
                    else 
                    { 
                        $sub += $this->count[$card_type]; 
                    } 
                } 
            } 
            else 
            { 
                break; 
            } 
        } 
        return $arr; 
    } 
} 


 //card num_or_face
$num_or_face = array("2","3","4","5","6","7","8","9","10","J","Q","K","A");
//suit of cards
$suit = array("C","D","H","S");


$deck = new card_deck();

//add type with num_or_face property and values from array
//and get id of type
$id = $deck->add_type("num_or_face", $num_or_face);

//add suit property to same type by providing id
$deck->add_type("suit", $suit, 1, $id);

//shuffle cards
$deck->shuffle();


//deal cards for 4 people, 2 cards for each
echo "<p>Player 1: ";
$arr = $deck->deal(2);
foreach($arr as $key => $val)
{
    // Implode built-in function: implode("", $val) --> inserts space between every value in array
    // Returns a string containing a string representation of all the array elements in the same
    // order, with the glue string between each element. 
    $arr[$key] = implode("", $val);
}
echo implode(" ", $arr);
echo "</p>";

echo "<p>Player 2: ";
$arr = $deck->deal(2);
foreach($arr as $key => $val)
{
    $arr[$key] = implode("", $val);
}
echo implode(" ", $arr);
echo "</p>";

echo "<p>Player 3: ";
$arr = $deck->deal(2);
foreach($arr as $key => $val)
{
    $arr[$key] = implode("", $val);
}
echo implode(" ", $arr);
echo "</p>";

echo "<p>Player 4: ";
$arr = $deck->deal(2);
foreach($arr as $key => $val)
{
    $arr[$key] = implode("", $val);
}
echo implode(" ", $arr);
echo "<p>";

//deal flop, turn and river
echo "<p>Flop: ";
$arr = $deck->deal(3);
foreach($arr as $key => $val)
{
    $arr[$key] = implode("", $val);
}
echo implode(" ", $arr);
echo "<p>";

echo "<p>Turn: ";
$arr = $deck->deal(1);
echo implode("", current($arr));
echo "</p>";

echo "<p>River: ";
$arr = $deck->deal(1);
echo implode("", current($arr));
echo "</p>";
?>