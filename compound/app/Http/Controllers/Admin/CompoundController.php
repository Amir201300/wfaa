<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class MediaController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Media::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('Admin.Compounds.index');
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|image|max:2000',
            ],
            [
                'image.required' =>'من فضلك ادخل صوره ',
                'image.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $this->save_Media($request,new Media);
        return $this->apiResponseMessage(1,'تم اضافة الصوره بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Media = Media::find($id);
        return $Media;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {

        $Media = Media::find($request->id);
        $this->save_Media($request,$Media);
        return $this->apiResponseMessage(1,'تم تعديل الصوره بنجاح',200);
    }

    /**
     * @param $request
     * @param $brand
     */
    public function save_Media($request,$Media){
        $Media->status=$request->status;
        if($request->image) {
            deleteFile('Compounds',$Media->image);
            $Media->image=saveImage('Compounds',$request->image);
        }
        $Media->save();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy($id,Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $Media = Media::whereIn('id', $ids)->get();
            foreach($Media as $row){
                $this->deleteRow($row);
            }
        } else {
            $Media = Media::find($id);
            $this->deleteRow($Media);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $cat
     */
    private function deleteRow($Media){
        deleteFile('Medias',$Media->image);
        $Media->delete();
    }

    /**
     * @param $id
     * @param Request $request
     * @return int
     */
    public function ChangeStatus($id,Request $request){
        $Media = Media::find($id);
        $Media->status=$request->status;
        $Media->save();
        return 1;
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="sl-icon-wrench"></i></button>';
            $options .= ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="sl-icon-trash"></i> </button></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Compounds',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Compounds',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->editColumn('status', function ($data) {
            $status = '<button class="btn waves-effect waves-light btn-rounded btn-success statusBut" style="cursor:pointer !important" onclick="ChangeStatus(2,'.$data->id.')" title="اضغط هنا لالغاء التفعيل">مفعل</button>';
            if ($data->status == 2)
                $status = '<button class="btn waves-effect waves-light btn-rounded btn-danger statusBut" onclick="ChangeStatus(1,'.$data->id.')" style="cursor:pointer !important" title="اضغط هنا للتفعيل">غير مفعل</button>';
            return $status;
        })->rawColumns(['action' => 'action','image' => 'image','checkBox'=>'checkBox','status'=>'status'])->make(true);
    }
}
