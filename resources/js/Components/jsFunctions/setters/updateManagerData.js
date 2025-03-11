export default async function updateManagerData(id, name, email, phone, pass) {
    try {
        const response = await fetch('/updateManager', {
            method: 'POST',
            body: JSON.stringify({
                id: id,
                name: name,
                email: email,
                phone: phone,
                pass: pass,
            }),
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
