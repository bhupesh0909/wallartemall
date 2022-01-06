<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class BannerController extends AppBaseController
{
    /** @var  BannerRepository */
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the Banner.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $banners = $this->bannerRepository->all();

        return view('banners.index')
            ->with('banners', $banners);
    }

    /**
     * Show the form for creating a new Banner.
     *
     * @return Response
     */
    public function create()
    {
        return view('banners.create');
    }

    /**
     * Store a newly created Banner in storage.
     *
     * @param CreateBannerRequest $request
     *
     * @return Response
     */
    public function store(CreateBannerRequest $request)
    {
		
		
		$request->validate([
				'is_active' => 'required',
				//'game_type' => 'required',
				'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		     ],[
				'banner_image.mimes' => 'Banner image must be in jpeg/jpg/png format.',
			]
		);
		
        $input = $request->all();

				
		
//        dd($request->all());
        if ($request->hasfile('banner_image')) {
            $image = $request->file('banner_image');
            $hash = hash_file('sha256', $image, false);
            $name = $hash . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('banner_image');
            $image->move($destinationPath, $name);
			
			
        }

		 $banner = Banner::create([
					'banner_image' => $name,
					'is_active' => $request->is_active,
				]);

        Flash::success('Banner saved successfully.');

        return redirect(route('banners.index'));
    }

    /**
     * Display the specified Banner.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

        return view('banners.show')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified Banner.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banner = $this->bannerRepository->find($id);
		


        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

        return view('banners.edit')->with('banner', $banner);
    }

    /**
     * Update the specified Banner in storage.
     *
     * @param int $id
     * @param UpdateBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBannerRequest $request)
    {
		
		
		/* $request->validate([
				'is_active' => 'required',
				//'game_type' => 'required',
				'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		     ],[
				'banner_image.mimes' => 'Banner image must be in jpeg/jpg/png format.',
			]
		);
		 */
		
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }
		
		
		 if ($request->hasfile('banner_image')) {
            $image = $request->file('banner_image');
            $hash = hash_file('sha256', $image, false);
            $name = $hash . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('banner_image');
            $image->move($destinationPath, $name);
			
			 $this->bannerRepository->update([
						'banner_image' => $name,
						'is_active' => $request->is_active,
					], $id);
			
        }
		
		

        Flash::success('Banner updated successfully.');

        return redirect(route('banners.index'));
    }

    /**
     * Remove the specified Banner from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $banner = $this->bannerRepository->find($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('banners.index'));
        }

        $this->bannerRepository->delete($id);

        Flash::success('Banner deleted successfully.');

        return redirect(route('banners.index'));
    }

    public function BannerIsActive($banner_id)
    {
        try {
            $chk_banner_is_active = Banner::where('id', $banner_id)->where('is_active', 'active')->exists();
            if ($chk_banner_is_active) {
                Banner::where('id', $banner_id)->update(['is_active' => 'inactive']);
            } else {
                Banner::where('id', $banner_id)->update(['is_active' => 'active']);
            }
            return back();
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'banner_is_active' => 0, 'message' => $e->getMessage()]);
        }
    }
}