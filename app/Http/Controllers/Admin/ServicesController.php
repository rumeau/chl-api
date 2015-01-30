<?php
namespace App\Http\Controllers\Admin;

use App\Content;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ServicesController
 * @package App\Http\Controllers\Admin
 */
class ServicesController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return $this
	 */
	public function getIndex(Request $request)
	{
		$services = Content::where('type', '=', Content::CONTENT_TYPE_SERVICE)->paginable($request)->paginate(15);

		return view('admin.services.index')->with('services', $services);
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function getCreate()
	{
		return view('admin.services.create');
	}

	/**
	 * @param Requests\Admin\ServiceRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postStore(Requests\Admin\ServiceRequest $request)
	{
		$parseMd = new \Parsedown();
		Content::create([
			'users_id' => \Auth::user()->id,
			'title' => $request->get('title'),
			'summary' => [
				'markdown' => $request->get('summary'),
				'html' => $parseMd->text($request->get('summary')),
			],
			'body' => [
				'markdown' => $request->get('body'),
				'html' => $parseMd->text($request->get('body')),
			],
			'type' => Content::CONTENT_TYPE_SERVICE,
			'api' => $request->get('api'),
		]);

		\Flash::success(trans('admin.service_create_success'));

		return redirect('/web/admin/services');
	}

	/**
	 * @param Content $service
	 * @return $this
	 */
	public function getEdit(Content $service)
	{
		return view('admin.services.edit')->with('service', $service);
	}

	/**
	 * @param Requests\Admin\ServiceRequest $request
	 * @param Content $service
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postUpdate(Requests\Admin\ServiceRequest $request, Content $service)
	{
		$parseMd = new \Parsedown();
		$service->title = $request->get('title', $service->title);
		$service->summary = [
			'markdown' => $request->get('summary', $service->summary['markdown']),
			'html' => $parseMd->text($request->get('summary', $service->summary['markdown'])),
		];
		$service->body = [
			'markdown' => $request->get('body', $service->body['markdown']),
			'html' => $parseMd->text($request->get('body', $service->body['markdown']))
		];
		$service->api = $request->get('api', $service->api);

		$service->save();

		\Flash::success(trans('admin.service_edit_success'));
		return redirect(route('services.index'));
	}

	/**
	 * @param Content $service
	 * @return $this
	 */
	public function getDelete(Content $service)
	{
		\Session::set('delete', $service->id);
		return view('admin.services.delete')->with('service', $service);
	}

	/**
	 * @param Requests\DeleteRequest $request
	 * @param Content $service
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function postDestroy(Requests\DeleteRequest $request, Content $service)
	{
		$sessionDelete = session('delete', -1);
		if ($request->get('element') != $sessionDelete || $service->id != $sessionDelete) {
			\Flash::error(trans('admin.service_delete_error'));
			return redirect(route('services.index'));
		}

		$service->delete();

		\Flash::success(trans('admin.service_delete_success'));
		return redirect(route('services.index'));
	}
}
