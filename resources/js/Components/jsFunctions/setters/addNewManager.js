export default async function addNewManager(name, email, phone, pass) {
    try {
        const response = await fetch('/addManager', {
            method: 'POST',
            body: {
                name: name,
                email: email,
                phone: phone,
                pass: pass,
            },
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
