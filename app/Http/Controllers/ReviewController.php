<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/* included models */
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        menuSubmenu('manage_order', 'manage_review');

        $reviews = Review::latest()->paginate(15);

        return view('backend.admin.order.review', compact('reviews'));
    }
    
    public function store(Request $request, $product_id, $user_id)
    {

        $user_review = Review::where([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ])->latest()->first();


        if ($user_review) {
            $review_data['rating'] = $request->rating;
            $review_data['comment'] = $request->comment;
            $review_data['updated_by'] = $user_id;
            $review_data['status'] = 0;
            $user_review->update($review_data);
        } else {
            $review = new Review;
            $review->product_id = $product_id;
            $review->user_id    = $user_id;
            $review->rating     = $request->rating;
            $review->comment    = $request->comment;
            $review->created_by = Auth::id();
            
            $review->save();

        }

        return redirect()->back()->with('success', 'Review has been submitted successfully!');
    }

    public function publish(Review $review)
    {
        $user = Auth::user();

        if(Gate::allows('publish_review', $user))
        {            
            if ($review->status == 0 || $review->status == 2) {
                $review->status       = 1;
                $review->updated_by   = Auth::id();
            }
            else if ($review->status == 0 || $review->status == 1) {
                $review->status       = 2;
                $review->updated_by   = Auth::id();
            }
    
            $review->save();
    
            return redirect()->route('admin.review.index')->with('success', 'Review Status Changed Successfully.'); 
        }
        else
        {
            abort(403);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        
        if(Gate::allows('delete_review', $user))
        {  
            Review::find($id)->delete();

            return redirect()->back()->with('success', 'Review Deleted Successfully');
        }
        else
        {
            abort(403);
        }
    }
}
