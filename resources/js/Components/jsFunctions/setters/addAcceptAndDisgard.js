export default async function addAcceptAndDisgard(
    accountancyId,
    accept,
    comment,
) {
    try {
        const response = await fetch('/addAcceptAndDisgard', {
            method: 'POST',
            body: JSON.stringify({
                accountancyId: accountancyId,
                accept: accept,
                comment: comment,
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
        const data = await response.json();

        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
