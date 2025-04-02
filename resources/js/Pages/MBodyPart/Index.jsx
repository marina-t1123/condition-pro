import React from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import { Link, useForm } from '@inertiajs/react';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    Image,
    HStack,
    Button,
    Center,
    Input,
    Stack,
} from '@chakra-ui/react';
import {
    DialogBody,
    DialogCloseTrigger,
    DialogContent,
    DialogHeader,
    DialogRoot,
    DialogTitle,
    DialogTrigger,
  } from "../../../../src/components/ui/dialog"
import { Field } from '../../../../src/components/ui/field';

const Index = ({m_body_parts}) => {

    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
                <Box className='main' width="90%" m="auto" bg='white' marginTop='20px' boxShadow='md' >
                    <HStack bg='gray.400' color='white'>
                        <Text textStyle={'2xl'} m='20px'>部位マスタ一覧</Text>
                    </HStack>

                    {/* テーブル */}
                    <Table.ScrollArea w="90%" m="auto" marginY="2rem" h="70vh" border="1px solid" borderColor="gray.200" p="1rem">
                        <Table.Root>
                            <Table.Header position="sticky" top="0" zIndex="1" bg='gray.400'>
                                <Table.Row>
                                    <Table.ColumnHeader borderBottom="2px solid" borderColor="gray.400" textAlign='center' w='60%' fontSize={'md'}>部位名</Table.ColumnHeader>
                                </Table.Row>
                            </Table.Header>

                            <Table.Body>
                                {m_body_parts.map((m_body_part, index) => (
                                    <Table.Row key={index}>
                                        <Table.Cell textAlign='center'  borderBottom="1px solid" borderColor="gray.300">{m_body_part.body_part_name}</Table.Cell>
                                    </Table.Row>
                                ))}
                            </Table.Body>
                        </Table.Root>
                    </Table.ScrollArea>
                </Box>

        </>
        </ChakraProvider>
    );
}

export default Index;
