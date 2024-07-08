<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Storage;
use Public\Uploads;
 
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'DESC')->get();

  
        return view('products.index', compact('product'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
 
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName;
 
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->video));
 
        // File URL to access the video in frontend
        $url = Storage::disk('public')->url($filePath);
 
        if ($isFileUploaded) {
            $video = new Product();
            $video->title = $request->title;
            $video->video = $filePath;
            $video->save();

            return redirect()->route('products')->with('success', 'Product added successfully');
        }

        return back() ->with('error','Unexpected error occured');
    }
        /*if ($request->has('video')) {
            $video = $request->file('video');
            $video_extenstion = strtolower($video->getClientOriginalExtension());
            $allow_extentions = array('mp4');
            
            if (!in_array($video_extenstion, $allow_extentions)) {
               return back()->withErrors(['msg' => 'Video format is not allowed only MP4 is allowed format']);
            }
            $filename = request()->title.'.';
            $path = $filename.$video_extenstion;
            $video_url = $video->move('uploads/video/', $path);
        }

      if ($video) {

        Product::create($request->all());
 
        return redirect()->route('products')->with('success', 'Product added successfully');
      }*/
      
    
    
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
  
        return view('products.show', compact('product'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
  
        return view('products.edit', compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
  
        $product->update($request->all());
  
        return redirect()->route('products')->with('success', 'product updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
  
        $product->delete();
  
        return redirect()->route('products')->with('success', 'product deleted successfully');
    }
}
