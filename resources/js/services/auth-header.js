export default function authHeader() {
    let accessToken = JSON.parse(sessionStorage.getItem('token'));

    if (accessToken) {
        return {
            Authorization: 'Bearer ' + accessToken,
            'Content-Type': 'application/json',
        };
    }
    return {
        "Content-Type": "application/json",
    };
}
