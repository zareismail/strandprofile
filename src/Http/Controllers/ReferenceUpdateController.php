<?php  

namespace Zareismail\Strandprofile\Http\Controllers;
 
use Illuminate\Http\Request;
use Laravel\Nova\Nova; 
use Zareismail\Strandprofile\Models\StrandprofileReference;

class ReferenceUpdateController extends Controller
{
    public function handle(Request $request, $hash)
    {  
    	$reference = tap(StrandprofileReference::whereHash($hash)->firstOrFail(), function($reference) use ($request) {
    		$reference->forceFill([
	    		'details' => array_merge((array) $reference->details, $request->all(), ['filled' => true]), 
	    	])->save(); 
    	}); 

    	return view('references::thankyou');
    } 
}
