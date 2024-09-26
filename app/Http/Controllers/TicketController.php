<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\ticketResponse;
use App\Models\TicketResponse as ModelsTicketResponse;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthCheck');
    }

    public function ticket_add(Request $request)
    {
        $data = [];
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required',
                'response' => 'required',
            ]);
            $ticket = Ticket::create([
                'title' => $request->title,
                'user_id' => Auth::id(),
                'issue_date' => date('Y-m-d', strtotime($request->issue_date)),
                'status' => 1
            ]);
            $ticket_id = $ticket->id;
            if ($ticket_id > 0) {
                ticketResponse::create([
                    'user_id' => Auth::id(),
                    'ticket_id' => $ticket_id,
                    'response' => $request->response,
                ]);
            }
            $admin = User::where('roll', 'admin')->first();
            $line = "A New Ticket Is Opened";
            $admin->notify(new TicketNotification($ticket, $line));
            return back()->with('success', 'Ticket Added Successfully');
        }
        $data['active_menu'] = 'ticket_add';
        $data['page_title'] = 'Ticket Add';
        return view('backend.pages.ticket_add', compact('data'));
    }
    public function ticket_list(Request $request)
    {
        $data = [];
        $user = Auth::user();
        $user_roll = $user->roll;
        $query = Ticket::select('id', 'title', 'issue_date', 'status');
        if ($user_roll == 'customer') {
            $query->where('user_id', $user->id);
        }
        $data['ticket_list'] = $query->get();
        $data['active_menu'] = 'ticket_list';
        $data['page_title'] = 'Ticket List';
        return view('backend.pages.ticket_list', compact('data'));
    }

    public function ticket_details(Request $request, $ticket_id)
    {
        $data = [];
        $user = Auth::user();
        $user_roll = $user->roll;
        if ($user_roll == 'admin') {
            $data['ticket'] = Ticket::find($ticket_id);
        } else {
            $data['ticket'] = Ticket::where('id', $ticket_id)->where('user_id', $user->id)->first();
        }
        if (!$data['ticket'])
            return redirect()->route('ticket.list')->with('error', 'Ticket Not Found');
        if ($request->isMethod('post')) {
            $ticket_status = $data['ticket']->status;
            if ($ticket_status == 1) {
                ticketResponse::create([
                    'user_id' => Auth::id(),
                    'ticket_id' => $ticket_id,
                    'response' => $request->response,
                ]);
                return back()->with('success', 'Your Response Send Successfully');
            }
        }
        $data['ticket_details'] = ticketResponse::where('ticket_id', $ticket_id)
            ->leftJoin('users', 'users.id', '=', 'ticket_responses.user_id')
            ->select('ticket_responses.id', 'ticket_responses.response', 'ticket_responses.created_at', 'users.name', 'users.roll')->orderBy('id')->get();
        $data['active_menu'] = 'ticket_details';
        $data['page_title'] = 'Ticket Details';
        return view('backend.pages.ticket_details', compact('data'));
    }
    public function ticket_status(Request $request, )
    {
        $ticket_id = $request->ticket_id ?? 0;
        $ticket = Ticket::find($ticket_id);
        if ($ticket) {
            $status = $request->status;
            $ticket->update([
                'status' => $status
            ]);
            if ($status == 2) {
                $user = User::where('id', $ticket->user_id)->first();
                $line = "Your Ticket Is Closed";
                $user->notify(new TicketNotification($ticket, $line));
            }
            return response()->json(['status' => true]);
        }
    }
}
