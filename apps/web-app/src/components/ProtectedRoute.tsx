import {useContext, type FC, type ReactNode} from 'react';
import { Navigate } from 'react-router-dom';
import { TokenContext } from '../context/TokenContext.tsx';

type Props = {
	children: ReactNode;
}

export const ProtectedRoute: FC<Props> = ({ children }) => {
	const token = useContext(TokenContext);

	if (token === null) {
		return <Navigate to='/login' replace />
	}

	return children;
}
