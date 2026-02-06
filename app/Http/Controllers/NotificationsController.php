<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getNotificationsData(Request $request)
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->whereNull('read_at')
            ->get(['data', 'created_at'])
            ->map(function($item) {
                return [
                    'icon'  => $item->data['icon'],
                    'text'  => $item->data['title'],
                    'time'  => $item->created_at->translatedFormat('d F Y'),
                    'url'   => $item->data['url'],
                ];
            })->toArray();

        $dropdownHtml = '';

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                   {$not['time']}
                 </span>";

            $dropdownHtml .= "<a href='{$not['url']}' class='dropdown-item'>
                            {$icon}{$not['text']}{$time}
                          </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Return the new notification data.

        return [
            'label' => count($notifications),
            'label_color' => 'danger',
            'icon_color' => 'dark',
            'dropdown' => $dropdownHtml,
        ];
    }

    public function show()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(request()->query('perPage', 10))
            ->withQueryString();

        return view('notifications.show', compact('notifications'));
    }
}
