<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contact;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);
        
        $stats = [
            'total' => Campaign::where('user_id', $request->user()->id)->count(),
            'completed' => Campaign::where('user_id', $request->user()->id)->where('status', 'completed')->count(),
            'sending' => Campaign::where('user_id', $request->user()->id)->where('status', 'sending')->count(),
        ];

        return view('admin.campaigns.index', compact('campaigns', 'stats'));
    }

    public function create()
    {
        $contacts = Contact::where('user_id', auth()->id())->where('is_active', true)->get();
        $groups = Contact::where('user_id', auth()->id())
            ->where('is_active', true)
            ->whereNotNull('group')
            ->distinct()
            ->pluck('group');
        
        return view('admin.campaigns.create', compact('contacts', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'channel' => 'required|in:email,sms,whatsapp',
            'message' => 'required',
            'subject' => 'nullable|max:255',
            'contact_type' => 'required|in:all,group,specific',
            'group' => 'nullable|required_if:contact_type,group',
            'contacts' => 'nullable|required_if:contact_type,specific|array',
        ]);

        // Calculate total contacts
        $totalContacts = 0;
        if ($request->contact_type === 'all') {
            $totalContacts = Contact::where('user_id', auth()->id())->where('is_active', true)->count();
        } elseif ($request->contact_type === 'group') {
            $totalContacts = Contact::where('user_id', auth()->id())
                ->where('group', $request->group)
                ->where('is_active', true)
                ->count();
        } else {
            $totalContacts = count($request->contacts ?? []);
        }

        Campaign::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'channel' => $request->channel,
            'message' => $request->message,
            'subject' => $request->subject,
            'status' => 'draft',
            'total_contacts' => $totalContacts,
            'contact_type' => $request->contact_type,
            'group' => $request->group,
            'selected_contacts' => $request->contacts ?? [],
        ]);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        return back()->with('success', 'Campaign updated!');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Campaign deleted!');
    }
}