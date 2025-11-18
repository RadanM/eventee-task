import {Link, useNavigate} from 'react-router-dom';
import {type FormEvent, useState} from "react";

export const Registration = () => {
	const [email, setEmail] = useState<string | null>(null);
	const [errorMessage, setErrorMessage] = useState(null);
	const [password, setPassword] = useState<string | null>(null);

	const navigate = useNavigate();

	const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
		e.preventDefault();

		setErrorMessage(null);

		fetch('http://127.0.0.1:8000/api/registerUser', {
			body: JSON.stringify({
				email: email,
				password: password,
			}),
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
			},
			method: 'POST'
		})
		.then((response) => response.json())
		.then((data) => {
			if (data.message) {
				setErrorMessage(data.message);
				return;
			}

			navigate('/login');
		});
	}

	return (
		<>
			<Link to="/login">
				Go to Login
			</Link>

			<h1>Registration</h1>

			{errorMessage && (
				<p>{errorMessage}</p>
			)}

			<form onSubmit={handleSubmit}>
				<label>
					E-mail
					<input
						type="email"
						name="email"
						onChange={(e) => { setEmail(e.target.value); }}
						required
					/>
				</label>

				<label>
					Password
					<input
						type="password"
						name="password"
						onChange={(e) => { setPassword(e.target.value); }}
						required
					/>
				</label>

				<button>
					Register
				</button>
			</form>
		</>
	);
}
