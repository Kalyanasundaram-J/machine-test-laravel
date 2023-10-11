<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MachineTestController extends Controller
{
    public function hello()
    {
        return ['message' => 'Hello, API!'];
    }
    public function task1(Request $request) {
        try{
            $request->validate([
                'limit1' => 'required|numeric|min:0',
                'limit2' => 'required|numeric|min:0',
            ]);
            $limit1 = (int)min($request->limit1,$request->limit2);
            $limit2 = (int)max($request->limit1,$request->limit2);
            $result = [];
            for($i = $limit1;$i <= $limit2;$i++){
                if($i == (int)strrev((string)$i)){
                    array_push($result,$i);
                }
            }
            return response()->json(['data'=>$result]);
        }
        catch(ValidationException $e) {
            return response()->json(['message' => 'Invalid parameters. Please enter a valid positive Number.'], 422);
        }
        catch(Exception $e){
            return response()->json(['message' => 'Server error'],500);
        }
    }

    public function task2(Request $request) {
        try {
            $request->validate([
                'longstring' => 'required|string|min:0'
            ]);
            $longString = $request->longstring;
            $length = strlen($longString);
            for($i=0;$i<floor($length/2);$i++) {
                $temp = $longString[$i];
                $longString[$i] = $longString[$length-$i-1];
                $longString[$length-$i-1] = $temp;
            }
            return response()->json(['data'=>$longString]);
        }
        catch(ValidationException $e) {
            return response()->json(['message' => 'Invalid parameters. Please enter a valid String.'], 422);
        }
        catch(Exception $e) {
            return response()->json(['message'=>'Server error'],500);
        }

    }

    public function task3(Request $request) {
        try {
            $request->validate([
                'number' => 'required|numeric|min:100|max:999'
            ]);
            $inputNumber = $request->number;
            $tempDigitArray = array();  //Store Each Digit of number
            $zeroCount = 0; // Count of zero in number
            $sameDigitCount = 0; // Count of same digits in number
            while($inputNumber){
                $digit = $inputNumber%10;
                $inputNumber = floor($inputNumber/10);
                if($digit==0){
                    $zeroCount += 1;
                }else {
                    for($i=0;$i<sizeof($tempDigitArray);$i++) {
                        // if there is same digit already in array we increase the count of sameCount variable and break
                        if($tempDigitArray[$i]==$digit){
                            $sameDigitCount += 1;
                            break;
                        }
                    }
                }
                array_push($tempDigitArray,$digit);
            }
            $result = 0;
            if($zeroCount>=2 or $sameDigitCount==2){
                $result = 1;
            }
            elseif($zeroCount==1){
                if($sameDigitCount==1){
                    $result = 2;
                }else{
                    $result = 4;
                }
            }elseif($sameDigitCount==1){
                $result = 3;
            }
            else{
                $result = 6;
            }
            return response()->json(['data'=>$result]);
        }
        catch(ValidationException $e) {
            return response()->json(['message' => 'Invalid parameters. Please enter a valid `3 Digit Number`.'], 422);
        }
        catch(Exception $e) {
            return response()->json(['message'=>'Server error'],500);
        }
    }
}
