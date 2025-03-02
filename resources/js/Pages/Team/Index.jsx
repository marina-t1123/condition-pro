import React from 'react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    TableRoot
} from '@chakra-ui/react';

const Teams = () => {
    return (
        <ChakraProvider value={defaultSystem}>

                <Box className='side-menu'>
                    
                </Box>

                <Box>
                    <Text textStyle={'3xl'} m={'20px'}>選手一覧</Text>
                    <Table.Root>
                        <Table.Header>
                            <Table.Row>
                                <Table.ColumnHeader>チーム名</Table.ColumnHeader>
                                <Table.ColumnHeader>種目</Table.ColumnHeader>
                                <Table.ColumnHeader>チーム詳細</Table.ColumnHeader>
                                <Table.ColumnHeader>所属選手一覧</Table.ColumnHeader>
                                <Table.ColumnHeader>傷病者一覧</Table.ColumnHeader>
                                <Table.ColumnHeader>分析一覧</Table.ColumnHeader>
                            </Table.Row>
                        </Table.Header>
                    </Table.Root>
                </Box>
        </ChakraProvider>
    );
}

export default Teams;
