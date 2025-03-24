export default async function sendHeadODSH(adressId, entrance, customer, size) {
    try {
        const response = await fetch('/setHeadODSH', {
            method: 'POST',
            body: JSON.stringify({
                adressId: adressId,
                entrance: entrance,
                customer: customer,
                size: size,
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
