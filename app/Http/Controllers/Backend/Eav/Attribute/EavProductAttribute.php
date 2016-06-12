<?php
/**
 * Created by Miki Maine Amdu.
 * For : INNOVATE E-COMMERCE
 * User: MIKI$
 * Date: 3/29/2016
 * Time: 6:08 PM.
 */
namespace App\Http\Controllers\Backend\Eav\Attribute;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Innovate\Repositories\Eav\Attribute\EavAttributeContract;
use Innovate\Repositories\Eav\Category\EavCategoryContract;
use Innovate\Requests\Eav\Attribute\StoreEavAttributeRequest;

class EavProductAttribute extends Controller
{
    public $eavAttribute;

    public $eavAttributeCategory;

    public function __construct(EavAttributeContract $eavAttribute, EavCategoryContract $eavCategoryContract)
    {
        $this->eavAttribute = $eavAttribute;
        $this->eavAttributeCategory = $eavCategoryContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.eav.attribute.index')
        ->withAttributes($this->eavAttribute->eagerLoadPaginated('product_category_id', config('access.users.default_per_page')));
        //return view('backend.eav.attribute.index')
          // ->withAttributes($this->eavAttribute->getAllEavAttribute());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.eav.attribute.create')
                 ->withEavcategorys($this->eavAttributeCategory->getAllEavCategory());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|StoreEavAttributeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEavAttributeRequest $request)
    {
        if ($request->ajax()) {
            return new JsonResponse($this->eavAttribute->create($request->all()));
        }

        $this->eavAttribute->create($request->all());

        return redirect()->route('admin.eav.attribute.index')->withFlashSuccess(trans('tax.alerts.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = $this->eavAttribute->findOrThrowException($id, true);
        $attribute->product_attribute_category->toArray();

        return view('backend.eav.attribute..edit')
                   ->withAttribute($attribute)
                   ->withEavcategorys($this->eavAttributeCategory->getAllEavCategory());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|StoreEavAttributeRequest $request
     * @param int                              $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEavAttributeRequest $request, $id)
    {
        $this->eavAttribute->update($id, $request->all());

        return redirect()->route('admin.eav.attribute.index')->withFlashSuccess(trans('eav.alerts.eav_attribute_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->eavAttribute->destroy($id);

        return redirect()->back()->withFlashSuccess(trans('eav.alerts.eav_attribute_deleted'));
    }
}
