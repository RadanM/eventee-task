import { createContext } from "react"

interface TokenContext {
	token: string | null;
	setToken: (token: string | null) => void;
}

export const TokenContext = createContext<TokenContext | null>(null);
