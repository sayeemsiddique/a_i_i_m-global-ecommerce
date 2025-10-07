<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\TemplateSetting;
/* included models */
use App\Models\Setting;

class SettingController extends Controller
{
    public function templateSetting()
    {
        menuSubmenu('', 'templateSetting');
        $user = Auth::user();

        // if (Gate::allows('settings', $user)) 
        // {
        //     if(Gate::allows('all_template',$user))
        //     {
                $templates = TemplateSetting::latest()->paginate(25);
                return view('backend.admin.setting.templateSetting',[
                    'templates' => $templates
                ]);
        //     }
        //     else
        //     {
        //         abort(403);
        //     }
            
        // }
        // else
        // {
        //     abort(403);
        // }

    }

    public function edit($id)
    {
        menuSubmenu('setup', 'setup');

        $user = Auth::user();

        if (Gate::allows('website_settings', $user)) 
        {
            
            $setting = Setting::where('id', $id)->first();

            return view('backend.admin.setting.edit', compact('setting'));
            
        }
        else
        {
            abort(403);
        }

    }

    public function setting_edit($id)
    {
        menuSubmenu('settings', 'order_settings');

        $user = Auth::user();

        if (Gate::allows('order_settings', $user)) 
        {
            $setting = Setting::where('id', $id)->first();

            return view('backend.admin.setting.order_setting', compact('setting'));
            
        }
        else
        {
            abort(403);
        }

    }

    public function update(Request $request, Setting $setting)
    {
        $setting->title             = $request->title;
        $setting->sub_title         = $request->sub_title;
        $setting->address           = $request->address;
        $setting->phone             = $request->phone;
        $setting->mobile            = $request->mobile;
        $setting->email             = $request->email;
        $setting->alt_phone         = $request->alt_phone;
        $setting->alt_mobile        = $request->alt_mobile;
        $setting->alt_email         = $request->alt_email;
        $setting->copyright         = $request->copyright;
        $setting->fb_link         = $request->fb_link;
        $setting->youtube_link         = $request->youtube_link;
        $setting->twitter_link         = $request->twitter_link;
        $setting->instagram_link         = $request->instagram_link;
        $setting->updated_by        = Auth::id();

        if($request->hasFile('logo'))
        {
            $cp = $request->file('logo');
            $extension = strtolower($cp->getClientOriginalExtension());
            $randomFileName = 'logo'.date('Y_m_d_his').'_'.rand(10000000,99999999).'.'.$extension;

            Storage::disk('public')->put('setting/'.$randomFileName, File::get($cp));

            $setting->logo = $randomFileName;
            $setting->save();
      	} 

        $setting->save();

        return redirect()->back()->with('success', 'Settings Updated Successfully.');
    }

    public function setting_update(Request $request, Setting $setting)
    {
        $setting->dealer_discount_flat      = $request->dealer_discount_flat;
        $setting->dealer_discount_percent   = $request->dealer_discount_percent;
        $setting->consumer_discount_flat    = $request->consumer_discount_flat;
        $setting->consumer_discount_percent = $request->consumer_discount_percent;
        $setting->vat                       = $request->vat;
        $setting->tax                       = $request->tax;
        $setting->error_flat                = $request->error_flat;
        $setting->error_percent             = $request->error_percent;
        $setting->courier_inside_dhaka      = $request->courier_inside_dhaka;
        $setting->courier_outside_dhaka     = $request->courier_outside_dhaka;
        $setting->updated_by                = Auth::id();

        $setting->save();

        return redirect()->back()->with('success', 'Settings Updated Successfully.');
    }

    public function createTemplate()
    {
        $user = Auth::user();

        // if (Gate::allows('settings', $user)) 
        // {
        //     if(Gate::allows('add_template',$user))
        //     {
                // $services = Service::where('id','<>',3)->get();
                // $certificate_service = Service::where('id',3)->first();
                // $service_items = ServiceItem::where('service_id',3)->get();
                // dd($service_items);
                    return view('backend.admin.setting.createTemplate',[
                    // 'services' => $services,
                    // 'certificate_service' => $certificate_service,
                    // 'service_items' =>$service_items
                ]);
        //     }
        //     else
        //     {
        //         abort(403);
        //     }
            
        // }
        // else
        // {
        //     abort(403);
        // }
        
    }

    public function storeTemplate(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [   'service' => ['required'],
            'header' => ['required','min:3','string'],
            'footer' => ['required','min:3','string'],
            // 'body' => ['required','min:3','string'],
        ]);

        if($validation->fails())
        {
            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray(),
                    'sessionMessage' => 'Please, fillup the form correctly and try again.'
                ));
            }

            return back()
            ->withInput()
            ->withErrors($validation);
        }
        $template = new TemplateSetting;
        $template->type = $request->service;
        if($request->service == 'other')
        {
            $template->service_id = $request->service_type_other;
        }
        elseif($request->service == 'certificate')
        {
            $template->service_id = $request->service_type_certificate;
            $template->service_item_id = $request->service_item;
        }
        $template->header = $request->header;
        $template->footer = $request->footer;
        $template->body = $request->body;
        $template->status = true;
        
        // dd($template);
        $template->save();

        return redirect()->route('admin.setting.templateSetting')->with('success','Template Create Successfully.');
    }

    public function editTemplate(TemplateSetting $template)
    {
        
        $user = Auth::user();

        // if (Gate::allows('settings', $user)) 
        // {
        //     if(Gate::allows('edit_template',$user))
        //     {
                // $services = Service::all();
                return view('backend.admin.setting.editTemplate',[
                    // 'services' => $services,
                    'template' => $template
                ]);
        //     }
        //     else
        //     {
        //         abort(403);
        //     }
            
        // }
        // else
        // {
        //     abort(403);
        // }
        
    }

    public function destroy(TemplateSetting $template)
    {
        $user = Auth::user();

        // if (Gate::allows('settings', $user)) 
        // {
        //     if(Gate::allows('status_template',$user))
        //     {
                if($template->status == 1)
                {
                    $template->status = false;
                    $template->save();

                    return back()->with('info','Template Disable Successfully.');
                }
                else
                {
                    $template->status = true;
                    $template->save();

                    return back()->with('info','Template Enable Successfully.');
                }
        //     }
        //     else
        //     {
        //         abort(403);
        //     }
            
        // }
        // else
        // {
        //     abort(403);
        // }

        
    }

    public function updateTemplate(Request $request, TemplateSetting $template)
    {
        $validation = Validator::make($request->all(),
        [   
            // 'service' => ['required'],
            'header' => ['required','min:3','string'],
            'footer' => ['required','min:3','string'],
            // 'body' => ['required','min:3','string'],
        ]);

        if($validation->fails())
        {
            if($request->ajax())
            {
                return Response()->json(array(
                    'success' => false,
                    'errors' => $validation->errors()->toArray(),
                    'sessionMessage' => 'Please, fillup the form correctly and try again.'
                ));
            }

            return back()
            ->withInput()
            ->withErrors($validation);
        }

        
        $template->service_id = $request->service;
        $template->header = $request->header;
        $template->footer = $request->footer;
        $template->body = $request->body;
        
        $template->save();

        return redirect()->route('admin.setting.templateSetting')->with('success','Template Create Successfully.');
    }

    public function showTemp(TemplateSetting $template)
    {
       return view('backend.admin.setting.showTemp',[
           'template' => $template
       ]);
    }
}
