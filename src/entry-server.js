import { createApp } from '../resources/js/app';

export async function renderToString(context) {
    const app = createApp(context);

    // You can perform server-side data fetching here, if needed.

    return app;
}
