const CACHE_NAME = 'zen-journey-v1';

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll([
                '/',
                '/index.html',
                '/favicon.ico'
            ]))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});

self.addEventListener('notificationclick', event => {
    event.notification.close();
    
    try {
        if (event.action === 'snooze') {
            // Reschedule notification for 5 minutes later
            const notification = event.notification;
            setTimeout(() => {
                self.registration.showNotification(notification.title, {
                    ...notification.options,
                    body: `[Snoozed] ${notification.body}`
                });
            }, 5 * 60 * 1000);
            return;
        }

        // Handle notification click
        if (event.notification.data) {
            event.waitUntil(
                clients.matchAll({ type: 'window' }).then(clientList => {
                    for (const client of clientList) {
                        if (client.url === event.notification.data.url && 'focus' in client) {
                            return client.focus();
                        }
                    }
                    if (clients.openWindow) {
                        return clients.openWindow(event.notification.data.url);
                    }
                })
            );
        }
    } catch (error) {
        console.error('Notification click handling error:', error);
    }
});

self.addEventListener('push', event => {
    if (!event.data) return;

    try {
        const data = event.data.json();
        event.waitUntil(
            self.registration.showNotification(data.title, {
                body: data.body,
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                tag: data.tag,
                requireInteraction: true,
                vibrate: [200, 100, 200],
                data: { 
                    url: self.registration.scope,
                    taskId: data.taskId,
                    type: data.type
                },
                actions: [
                    {
                        action: 'acknowledge',
                        title: 'Acknowledge'
                    },
                    {
                        action: 'snooze',
                        title: 'Snooze'
                    }
                ]
            })
        );
    } catch (error) {
        console.error('Push event processing error:', error);
    }
});

// Add error handling and reporting
self.addEventListener('error', event => {
    console.error('Service Worker error:', event.error);
});
