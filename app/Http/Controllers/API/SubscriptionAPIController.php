<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSubscriptionAPIRequest;
use App\Http\Requests\API\UpdateSubscriptionAPIRequest;
use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers\API
 */

class SubscriptionAPIController extends AppBaseController
{
    /** @var  SubscriptionRepository */
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepo)
    {
        $this->subscriptionRepository = $subscriptionRepo;
    }

    /**
     * Display a listing of the Subscription.
     * GET|HEAD /subscriptions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $subscriptions = $this->subscriptionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($subscriptions->toArray(), 'Subscriptions retrieved successfully');
    }

    /**
     * Store a newly created Subscription in storage.
     * POST /subscriptions
     *
     * @param CreateSubscriptionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSubscriptionAPIRequest $request)
    {
        $input = $request->all();

        $subscription = $this->subscriptionRepository->create($input);

        return $this->sendResponse($subscription->toArray(), 'Subscription saved successfully');
    }

    /**
     * Display the specified Subscription.
     * GET|HEAD /subscriptions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Subscription $subscription */
        $subscription = $this->subscriptionRepository->find($id);

        if (empty($subscription)) {
            return $this->sendError('Subscription not found');
        }

        return $this->sendResponse($subscription->toArray(), 'Subscription retrieved successfully');
    }

    /**
     * Update the specified Subscription in storage.
     * PUT/PATCH /subscriptions/{id}
     *
     * @param int $id
     * @param UpdateSubscriptionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubscriptionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Subscription $subscription */
        $subscription = $this->subscriptionRepository->find($id);

        if (empty($subscription)) {
            return $this->sendError('Subscription not found');
        }

        $subscription = $this->subscriptionRepository->update($input, $id);

        return $this->sendResponse($subscription->toArray(), 'Subscription updated successfully');
    }

    /**
     * Remove the specified Subscription from storage.
     * DELETE /subscriptions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Subscription $subscription */
        $subscription = $this->subscriptionRepository->find($id);

        if (empty($subscription)) {
            return $this->sendError('Subscription not found');
        }

        $subscription->delete();

        return $this->sendSuccess('Subscription deleted successfully');
    }
}
