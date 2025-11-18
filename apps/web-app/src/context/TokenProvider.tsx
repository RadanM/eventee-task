import {type ReactNode, type FC, useState, useEffect} from "react";
import { TokenContext } from "./TokenContext.tsx";

type Props = {
	children: ReactNode
}

export const TokenProvider: FC<Props> = ({ children }) => {
	const [token, setToken] = useState<string | null>(null);

	const getTokenCookie = () => {
		const match = document.cookie.match(new RegExp('(^| )token=([^;]+)'));
		return match ? match[2] : null;
	};

	useEffect(() => {
		setToken(getTokenCookie);
	}, [getTokenCookie]);

	return (
		<TokenContext.Provider value={{ token, setToken }}>
			{children}
		</TokenContext.Provider>
	);
}